<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersCreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('UsersCreate', [
            'title' => 'Add new user',
            'description' => 'Create a new user for the Hermes system.',
        ]);
    }
}
