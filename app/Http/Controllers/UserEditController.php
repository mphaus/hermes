<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\WithUserPermissions;
use Inertia\Inertia;

class UserEditController extends Controller
{
    use WithUserPermissions;

    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        return Inertia::render('UserEdit', [
            'user' => $user,
            'title' => 'Edit user',
            'description' => 'Edit the user details.',
            'permissions' => $this->getPermissions(),
        ]);
    }
}
