<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'first_name' => 'Admin',
        'last_name' => 'User',
        'is_enabled' => true,
        'is_admin' => true,
        'permissions' => [],
    ]);
});

function validPasswordData(): array
{
    return [
        'password' => 'averylongpassword16',
    ];
}

describe('UserUpdatePasswordController', function () {
    it('requires authentication', function () {
        $user = User::factory()->create(['permissions' => []]);

        $response = $this->put(route('inertia.users.change-password.update', $user), validPasswordData());

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
            ->put(route('inertia.users.change-password.update', $user), validPasswordData());

        $response->assertNotFound();
    });

    it('successfully updates the user password and redirects to show', function () {
        $user = User::factory()->create([
            'password' => bcrypt('oldpasswordstring'),
            'permissions' => [],
        ]);
        $newPassword = 'newverylongpassword!';

        $response = $this->actingAs($this->admin)
            ->put(route('inertia.users.change-password.update', $user), ['password' => $newPassword]);

        $response->assertRedirect(route('inertia.users.show', $user));

        $user->refresh();
        expect(Hash::check($newPassword, $user->password))->toBeTrue();
    });

    it('flashes a success toast', function () {
        $user = User::factory()->create(['permissions' => []]);
        $newPassword = 'anotherverylongpass';

        $response = $this->actingAs($this->admin)
            ->put(route('inertia.users.change-password.update', $user), ['password' => $newPassword]);

        $response->assertSessionHas('inertia.flash_data', function ($flash) {
            return isset($flash['toast'])
                && $flash['toast']['type'] === 'success'
                && $flash['toast']['message'] === 'User password updated successfully.';
        });
    });
});
