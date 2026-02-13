<?php

use App\Models\User;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'first_name' => 'Admin',
        'last_name' => 'User',
        'is_enabled' => true,
        'is_admin' => true,
        'permissions' => [],
    ]);
});

describe('UserDestroyController', function () {
    it('requires authentication', function () {
        $user = User::factory()->create(['permissions' => []]);

        $response = $this->delete(route('users.destroy', $user));

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
            ->delete(route('users.destroy', $user));

        $response->assertNotFound();
    });

    it('prevents an admin from deleting themselves', function () {
        $response = $this->actingAs($this->admin)
            ->delete(route('users.destroy', $this->admin));

        $response->assertNotFound();
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    });

    it('successfully deletes a user and redirects to inertia users index', function () {
        $user = User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'permissions' => [],
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    });

    it('flashes a success toast with the deleted user full name', function () {
        $user = User::factory()->create([
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'permissions' => [],
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(route('users.destroy', $user));

        $response->assertSessionHas('inertia.flash_data', function ($flash) {
            return isset($flash['toast'])
                && $flash['toast']['type'] === 'success'
                && $flash['toast']['message'] === 'User Jane Doe has been deleted.';
        });
    });
});
