<?php

use App\Models\User;
use Illuminate\Support\Str;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'first_name' => 'Admin',
        'last_name' => 'User',
        'is_enabled' => true,
        'is_admin' => true,
        'permissions' => [],
    ]);
});

function validUserUpdateData(User $user, array $overrides = []): array
{
    $unique = Str::random(8);

    return [
        'first_name' => 'Updated',
        'last_name' => 'Name',
        'username' => "updated{$unique}",
        'email' => "updated{$unique}@example.com",
        'is_admin' => '0',
        'is_enabled' => '1',
        'permissions' => ['access-action-stream'],
        ...$overrides,
    ];
}

describe('UserUpdateController', function () {
    it('requires authentication', function () {
        $user = User::factory()->create(['permissions' => []]);

        $response = $this->put(route('users.update', $user), validUserUpdateData($user));

        $response->assertRedirect();
        expect($response->isRedirect())->toBeTrue();
    });

    it('requires the crud-users permission', function () {
        $userWithoutPermission = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => [],
        ]);
        $user = User::factory()->create(['permissions' => []]);

        $response = $this->actingAs($userWithoutPermission)
            ->put(route('users.update', $user), validUserUpdateData($user));

        $response->assertNotFound();
    });

    it('successfully updates a user and redirects to inertia users index', function () {
        $user = User::factory()->create([
            'first_name' => 'Original',
            'last_name' => 'User',
            'username' => 'originaluser',
            'email' => 'original@example.com',
            'permissions' => [],
        ]);
        $data = validUserUpdateData($user);

        $response = $this->actingAs($this->admin)
            ->put(route('users.update', $user), $data);

        $response->assertRedirect(route('users.index'));

        $user->refresh();
        expect($user->first_name)->toBe($data['first_name']);
        expect($user->last_name)->toBe($data['last_name']);
        expect($user->username)->toBe($data['username']);
        expect($user->email)->toBe($data['email']);
        expect($user->is_enabled)->toBeTrue();
    });

    it('flashes a success toast', function () {
        $user = User::factory()->create(['permissions' => []]);
        $data = validUserUpdateData($user);

        $response = $this->actingAs($this->admin)
            ->put(route('users.update', $user), $data);

        $response->assertSessionHas('inertia.flash_data', function ($flash) {
            return isset($flash['toast'])
                && $flash['toast']['type'] === 'success'
                && $flash['toast']['message'] === 'User updated successfully.';
        });
    });

    it('updates to admin user when is_admin is 1', function () {
        $user = User::factory()->create([
            'is_admin' => false,
            'permissions' => ['access-action-stream'],
        ]);
        $data = validUserUpdateData($user, [
            'is_admin' => '1',
            'permissions' => [],
        ]);

        $response = $this->actingAs($this->admin)
            ->put(route('users.update', $user), $data);

        $response->assertRedirect(route('users.index'));

        $user->refresh();
        expect($user->is_admin)->toBeTrue();
        expect($user->permissions->toArray())->toBe([]);
    });

    describe('validation', function () {
        it('requires first_name', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['first_name' => null]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('first_name');
        });

        it('validates first_name min length', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['first_name' => 'A']);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('first_name');
        });

        it('requires last_name', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['last_name' => null]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('last_name');
        });

        it('validates last_name min length', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['last_name' => 'B']);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('last_name');
        });

        it('requires username', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['username' => null]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('username');
        });

        it('validates username min length', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['username' => 'abcd']);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('username');
        });

        it('allows same username when updating the same user', function () {
            $user = User::factory()->create([
                'username' => 'sameusername',
                'permissions' => [],
            ]);
            $data = validUserUpdateData($user, ['username' => $user->username]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertRedirect(route('users.index'));
            $response->assertSessionHasNoErrors();
        });

        it('validates username is unique for another user', function () {
            $other = User::factory()->create(['username' => 'takenusername', 'permissions' => []]);
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['username' => $other->username]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('username');
        });

        it('requires email', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['email' => null]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('email');
        });

        it('validates email format', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['email' => 'not-an-email']);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('email');
        });

        it('allows same email when updating the same user', function () {
            $user = User::factory()->create([
                'email' => 'same@example.com',
                'permissions' => [],
            ]);
            $data = validUserUpdateData($user, ['email' => $user->email]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertRedirect(route('users.index'));
            $response->assertSessionHasNoErrors();
        });

        it('validates email is unique for another user', function () {
            $other = User::factory()->create(['email' => 'taken@example.com', 'permissions' => []]);
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['email' => $other->email]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('email');
        });

        it('requires permissions when not admin', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['permissions' => null]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('permissions');
        });

        it('does not require permissions when is_admin is 1', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, [
                'is_admin' => '1',
                'permissions' => [],
            ]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertRedirect(route('users.index'));
            $response->assertSessionHasNoErrors();
        });

        it('validates permissions contain only allowed values when not admin', function () {
            $user = User::factory()->create(['permissions' => []]);
            $data = validUserUpdateData($user, ['permissions' => ['invalid-permission']]);

            $response = $this->actingAs($this->admin)
                ->put(route('users.update', $user), $data);

            $response->assertSessionHasErrors('permissions.0');
        });
    });
});
