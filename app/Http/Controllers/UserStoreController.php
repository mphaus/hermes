<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use Inertia\Inertia;

class UserStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserStoreRequest $request)
    {
        $request->store();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'User created successfully.',
        ]);

        return to_route('inertia.users.index');
    }
}
