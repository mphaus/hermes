<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return Inertia::render('UserIndex', [
            'title' => 'Users',
            'description' => 'Create, Rename, Update and Delete (CRUD) Hermes system users.',
            'users_data' => User::query()
                ->orderBy('first_name', 'asc')
                ->orderBy('last_name', 'asc')
                ->paginate(25),
        ]);
    }
}
