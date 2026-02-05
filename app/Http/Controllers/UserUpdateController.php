<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

class UserUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user, UserUpdateRequest $request)
    {
        $request->store();
        return to_route('inertia.users.index');
    }
}
