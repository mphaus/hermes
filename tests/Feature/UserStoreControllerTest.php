<?php

use App\Models\User;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->user = User::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'is_enabled' => true,
        'is_admin' => true,
        'permissions' => [],
    ]);
});

function validUserData(array $overrides = []): array
{
    $unique = Str::random(8);

    return [
        'first_name' => 'Jane',
        'last_name' => 'Smith',
        'username' => "user{$unique}",
        'email' => "user{$unique}@example.com",
        'password' => 'password-with-16-chars',
        'is_admin' => '0',
        'is_enabled' => '0',
        'permissions' => ['access-action-stream'],
        ...$overrides,
    ];
}

describe('UserStoreController', function () {
    it('requires authentication', function () {
        $response = $this->post(route('inertia.users.store'), validUserData());

        $response->assertRedirect();
        expect($response->isRedirect())->toBeTrue();
    });

    it('requires the crud-users permission', function () {
        $userWithoutPermission = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => [],
        ]);

        $response = $this->actingAs($userWithoutPermission)
            ->post(route('inertia.users.store'), validUserData());

        $response->assertNotFound();
    });

    it('successfully creates a user and redirects to inertia users index', function () {
        $data = validUserData();

        $response = $this->actingAs($this->user)
            ->post(route('inertia.users.store'), $data);

        $response->assertRedirect(route('inertia.users.index'));

        $this->assertDatabaseHas('users', [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'email' => $data['email'],
        ]);
    });

    it('creates an admin user when is_admin is 1', function () {
        $data = validUserData([
            'is_admin' => '1',
            'permissions' => [],
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('inertia.users.store'), $data);

        $response->assertRedirect(route('inertia.users.index'));

        $user = User::where('username', $data['username'])->first();
        expect($user->is_admin)->toBeTrue();
        expect($user->permissions->toArray())->toBe([]);
    });

    describe('validation', function () {
        it('requires first_name', function () {
            $data = validUserData(['first_name' => null]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('first_name');
        });

        it('validates first_name min length', function () {
            $data = validUserData(['first_name' => 'A']);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('first_name');
        });

        it('requires last_name', function () {
            $data = validUserData(['last_name' => null]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('last_name');
        });

        it('validates last_name min length', function () {
            $data = validUserData(['last_name' => 'B']);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('last_name');
        });

        it('requires username', function () {
            $data = validUserData(['username' => null]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('username');
        });

        it('validates username min length', function () {
            $data = validUserData(['username' => 'abcd']);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('username');
        });

        it('validates username is unique', function () {
            $existing = User::factory()->create(['permissions' => []]);
            $data = validUserData(['username' => $existing->username]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('username');
        });

        it('requires email', function () {
            $data = validUserData(['email' => null]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('email');
        });

        it('validates email format', function () {
            $data = validUserData(['email' => 'not-an-email']);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('email');
        });

        it('validates email is unique', function () {
            $existing = User::factory()->create(['permissions' => []]);
            $data = validUserData(['email' => $existing->email]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('email');
        });

        it('requires password', function () {
            $data = validUserData(['password' => null]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('password');
        });

        it('validates password min length', function () {
            $data = validUserData(['password' => 'short']);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('password');
        });

        it('requires permissions when not admin', function () {
            $data = validUserData(['permissions' => null]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('permissions');
        });

        it('does not require permissions when is_admin is 1', function () {
            $data = validUserData([
                'is_admin' => '1',
                'permissions' => [],
            ]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertRedirect(route('inertia.users.index'));
            $response->assertSessionHasNoErrors();
        });

        it('validates permissions contain only allowed values when not admin', function () {
            $data = validUserData(['permissions' => ['invalid-permission']]);

            $response = $this->actingAs($this->user)
                ->post(route('inertia.users.store'), $data);

            $response->assertSessionHasErrors('permissions.0');
        });
    });
});
