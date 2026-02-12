<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdatePasswordRequest;
use App\Models\User;
use Inertia\Inertia;

class UserUpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, UserUpdatePasswordRequest $request)
    {
        $request->store();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'User password updated successfully.',
        ]);

        return to_route('inertia.users.show', ['user' => $user]);
    }
}
