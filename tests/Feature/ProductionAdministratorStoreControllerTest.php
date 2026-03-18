<?php

use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Http::preventStrayRequests();

    Config::set('app.mph.production_administrator_list_id', 456);

    Http::fake(function (Request $request) {
        if (!str_contains($request->url(), 'list_names')) {
            return null;
        }
        if ($request->method() === 'GET') {
            return Http::response([
                'list_name' => [
                    'list_values' => [
                        ['id' => 1, 'name' => 'Existing One', 'list_name_id' => 456],
                    ],
                ],
            ], 200);
        }
        if ($request->method() === 'PUT') {
            return Http::response(['list_name' => ['id' => 456]], 200);
        }
        return null;
    });

    $this->user = User::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'is_enabled' => true,
        'is_admin' => true,
        'permissions' => [],
    ]);
});

function validProductionAdministratorData(array $overrides = []): array
{
    return [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        ...$overrides,
    ];
}

describe('ProductionAdministratorStoreController', function () {
    it('requires authentication', function () {
        $response = $this->post(route('production-administrators.store'), validProductionAdministratorData());

        $response->assertRedirect();
        expect($response->isRedirect())->toBeTrue();
    });

    it('requires the crud-production-administrators permission', function () {
        $userWithoutPermission = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => ['access-action-stream'],
        ]);

        $response = $this->actingAs($userWithoutPermission)
            ->post(route('production-administrators.store'), validProductionAdministratorData());

        $response->assertNotFound();
    });

    it('successfully creates a production administrator and redirects to index', function () {
        $data = validProductionAdministratorData();

        $response = $this->actingAs($this->user)
            ->post(route('production-administrators.store'), $data);

        $response->assertRedirect(route('production-administrators.index'));

        Http::assertSent(function (Request $request) {
            if ($request->method() === 'PUT') {
                $body = $request->data();
                $listValues = $body['list_name']['list_values'] ?? [];
                $names = array_column($listValues, 'name');
                return in_array('Jane Smith', $names);
            }
            return true;
        });
    });

    it('flashes success toast on successful create', function () {
        $response = $this->actingAs($this->user)
            ->post(route('production-administrators.store'), validProductionAdministratorData());

        $response->assertRedirect(route('production-administrators.index'));
        $response->assertSessionHas('inertia.flash_data', function ($flash) {
            return isset($flash['toast'])
                && $flash['toast']['type'] === 'success'
                && $flash['toast']['message'] === 'Production Administrator created successfully.';
        });
    });

    it('redirects back to create with errors when fetch (GET) fails', function () {
        $freshFactory = new \Illuminate\Http\Client\Factory();
        Http::swap($freshFactory);
        Http::preventStrayRequests();
        Http::fake(function (Request $request) {
            if (!str_contains($request->url(), 'list_names')) {
                return null;
            }
            if ($request->method() === 'GET') {
                return Http::response(['errors' => ['Server Error']], 500);
            }
            return null;
        });

        $response = $this->actingAs($this->user)
            ->post(route('production-administrators.store'), validProductionAdministratorData());

        $response->assertRedirect(route('production-administrators.create'));
        $response->assertSessionHasErrors('message');
    });

    it('redirects back to create with errors when update (PUT) fails', function () {
        $freshFactory = new \Illuminate\Http\Client\Factory();
        Http::swap($freshFactory);
        Http::preventStrayRequests();
        Http::fake(function (Request $request) {
            if (!str_contains($request->url(), 'list_names')) {
                return null;
            }
            if ($request->method() === 'GET') {
                return Http::response([
                    'list_name' => ['list_values' => []],
                ], 200);
            }
            if ($request->method() === 'PUT') {
                return Http::response(['errors' => ['Update failed']], 500);
            }
            return null;
        });

        $response = $this->actingAs($this->user)
            ->post(route('production-administrators.store'), validProductionAdministratorData());

        $response->assertRedirect(route('production-administrators.create'));
        $response->assertSessionHasErrors('message');
    });

    describe('validation', function () {
        it('requires first_name', function () {
            $data = validProductionAdministratorData(['first_name' => null]);

            $response = $this->actingAs($this->user)
                ->post(route('production-administrators.store'), $data);

            $response->assertSessionHasErrors('first_name');
        });

        it('validates first_name must be alpha_dash', function () {
            $data = validProductionAdministratorData(['first_name' => 'Jane Doe!']);

            $response = $this->actingAs($this->user)
                ->post(route('production-administrators.store'), $data);

            $response->assertSessionHasErrors('first_name');
        });

        it('requires last_name', function () {
            $data = validProductionAdministratorData(['last_name' => null]);

            $response = $this->actingAs($this->user)
                ->post(route('production-administrators.store'), $data);

            $response->assertSessionHasErrors('last_name');
        });

        it('validates last_name must be alpha_dash', function () {
            $data = validProductionAdministratorData(['last_name' => 'Smith Jr.']);

            $response = $this->actingAs($this->user)
                ->post(route('production-administrators.store'), $data);

            $response->assertSessionHasErrors('last_name');
        });
    });
});
