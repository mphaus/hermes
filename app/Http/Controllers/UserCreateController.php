<?php

namespace App\Http\Controllers;

use App\Traits\WithUserPermissions;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserCreateController extends Controller
{
    use WithUserPermissions;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('UsersCreate', [
            'title' => 'Add new user',
            'description' => 'Create a new user for the Hermes system.',
            'permissions' => $this->getPermissions(),
        ]);
    }
}
