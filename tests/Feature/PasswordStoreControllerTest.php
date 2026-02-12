<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

function validPasswordStoreData(array $overrides = []): array
{
    return [
        'current_password' => 'current-password-123',
        'password' => 'new-password-12345',
        'password_confirmation' => 'new-password-12345',
        ...$overrides,
    ];
}

describe('PasswordStoreController', function () {
    it('requires authentication', function () {
        $response = $this->post(route('change-password.store'), validPasswordStoreData());

        $response->assertRedirect(route('login'));
    });

    it('validates the current password', function () {
        $user = User::factory()->create([
            'password' => Hash::make('current-password-123'),
            'permissions' => [],
        ]);

        $response = $this->actingAs($user)->post(route('change-password.store'), validPasswordStoreData([
            'current_password' => 'wrong-password-123',
        ]));

        $response->assertSessionHasErrors('current_password');
    });

    it('updates the password, logs the user out, flashes success, and redirects to login', function () {
        $user = User::factory()->create([
            'password' => Hash::make('current-password-123'),
            'permissions' => [],
        ]);
        $newPassword = 'new-password-12345';

        $response = $this->actingAs($user)->post(route('change-password.store'), validPasswordStoreData([
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('alert', [
            'type' => 'success',
            'message' => 'Your password has been reset successfully. Please log in with your new password.',
        ]);

        $user->refresh();
        expect(Hash::check($newPassword, $user->password))->toBeTrue();
        $this->assertGuest();
    });
});
