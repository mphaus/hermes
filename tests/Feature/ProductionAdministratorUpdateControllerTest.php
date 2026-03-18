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

    $this->productionAdministratorId = 1;
});

function validProductionAdministratorDataForUpdate(array $overrides = []): array
{
    return [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        ...$overrides,
    ];
}

describe('ProductionAdministratorUpdateController', function () {
    it('requires authentication', function () {
        $response = $this->put(
            route('production-administrators.update', $this->productionAdministratorId),
            validProductionAdministratorDataForUpdate()
        );

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
            ->put(
                route('production-administrators.update', $this->productionAdministratorId),
                validProductionAdministratorDataForUpdate()
            );

        $response->assertNotFound();
    });

    it('successfully updates a production administrator and redirects to index', function () {
        $data = validProductionAdministratorDataForUpdate();

        $response = $this->actingAs($this->user)
            ->put(
                route('production-administrators.update', $this->productionAdministratorId),
                $data
            );

        $response->assertRedirect(route('production-administrators.index'));

        Http::assertSent(function (Request $request) {
            if ($request->method() === 'PUT') {
                $body = $request->data();
                $listValues = $body['list_name']['list_values'] ?? [];
                $updated = collect($listValues)->firstWhere('id', 1);
                return $updated && $updated['name'] === 'Jane Smith';
            }
            return true;
        });
    });

    it('flashes success toast on successful update', function () {
        $response = $this->actingAs($this->user)
            ->put(
                route('production-administrators.update', $this->productionAdministratorId),
                validProductionAdministratorDataForUpdate()
            );

        $response->assertRedirect(route('production-administrators.index'));
        $response->assertSessionHas('inertia.flash_data', function ($flash) {
            return isset($flash['toast'])
                && $flash['toast']['type'] === 'success'
                && $flash['toast']['message'] === 'Production Administrator updated successfully.';
        });
    });

    it('redirects back to edit with errors when fetch (GET) fails', function () {
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
            ->put(
                route('production-administrators.update', $this->productionAdministratorId),
                validProductionAdministratorDataForUpdate()
            );

        $response->assertRedirect(route('production-administrators.edit', $this->productionAdministratorId));
        $response->assertSessionHasErrors('message');
    });

    it('redirects back to edit with errors when update (PUT) fails', function () {
        $freshFactory = new \Illuminate\Http\Client\Factory();
        Http::swap($freshFactory);
        Http::preventStrayRequests();
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
                return Http::response(['errors' => ['Update failed']], 500);
            }
            return null;
        });

        $response = $this->actingAs($this->user)
            ->put(
                route('production-administrators.update', $this->productionAdministratorId),
                validProductionAdministratorDataForUpdate()
            );

        $response->assertRedirect(route('production-administrators.edit', $this->productionAdministratorId));
        $response->assertSessionHasErrors('message');
    });

    describe('validation', function () {
        it('requires first_name', function () {
            $data = validProductionAdministratorDataForUpdate(['first_name' => null]);

            $response = $this->actingAs($this->user)
                ->put(
                    route('production-administrators.update', $this->productionAdministratorId),
                    $data
                );

            $response->assertSessionHasErrors('first_name');
        });

        it('validates first_name must be alpha_dash', function () {
            $data = validProductionAdministratorDataForUpdate(['first_name' => 'Jane Doe!']);

            $response = $this->actingAs($this->user)
                ->put(
                    route('production-administrators.update', $this->productionAdministratorId),
                    $data
                );

            $response->assertSessionHasErrors('first_name');
        });

        it('requires last_name', function () {
            $data = validProductionAdministratorDataForUpdate(['last_name' => null]);

            $response = $this->actingAs($this->user)
                ->put(
                    route('production-administrators.update', $this->productionAdministratorId),
                    $data
                );

            $response->assertSessionHasErrors('last_name');
        });

        it('validates last_name must be alpha_dash', function () {
            $data = validProductionAdministratorDataForUpdate(['last_name' => 'Smith Jr.']);

            $response = $this->actingAs($this->user)
                ->put(
                    route('production-administrators.update', $this->productionAdministratorId),
                    $data
                );

            $response->assertSessionHasErrors('last_name');
        });
    });
});
