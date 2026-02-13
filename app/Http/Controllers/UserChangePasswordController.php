<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        return Inertia::render('UserChangePassword', [
            'title' => 'Change user password',
            'description' => "Change {$user->first_name} {$user->last_name}'s password.",
            'user' => $user,
        ]);
    }
}
