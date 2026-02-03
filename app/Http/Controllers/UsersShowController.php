<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UsersShowController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        return Inertia::render('UsersShow', [
            'user' => $user,
        ]);
    }
}
