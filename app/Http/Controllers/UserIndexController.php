<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('UserIndex', [
            'title' => 'Users',
            'description' => 'Create, Rename, Update and Delete (CRUD) Hermes system users.',
            'users_data' => User::query()
                ->exceptSuperAdmin()
                ->orderBy('first_name', 'asc')
                ->orderBy('last_name', 'asc')
                ->paginate(25),
        ]);
    }
}
