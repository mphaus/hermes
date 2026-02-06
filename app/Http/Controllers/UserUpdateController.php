<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Inertia\Inertia;

class UserUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, UserUpdateRequest $request)
    {
        $request->store();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'User updated successfully.',
        ]);

        return to_route('inertia.users.index');
    }
}
