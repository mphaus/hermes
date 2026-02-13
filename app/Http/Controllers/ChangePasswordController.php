<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return Inertia::render('ChangePassword', [
            'title' => 'Change Password',
            'description' => 'After changing your password, you will be logged out and will need to log in again with your new password.',
        ]);
    }
}
