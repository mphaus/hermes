<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\WithUserPermissions;
use Inertia\Inertia;

class UsersEditController extends Controller
{
    use WithUserPermissions;

    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        return Inertia::render('UsersEdit', [
            'user' => $user,
            'title' => 'Edit user',
            'description' => 'Edit the user details.',
            'permissions' => $this->getPermissions(),
        ]);
    }
}
