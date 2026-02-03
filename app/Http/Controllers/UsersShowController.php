<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\WithUserPermissions;
use Inertia\Inertia;

class UsersShowController extends Controller
{
    use WithUserPermissions;

    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        $permissions = array_map(function ($permission) {
            return [
                'value' => $permission['value'],
                'label' => $permission['label'],
            ];
        }, $this->getPermissions());

        return Inertia::render('UsersShow', [
            'user' => $user,
            'permissions' => $permissions,
        ]);
    }
}
