<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserDestroyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(User $user)
    {
        $full_name = $user->full_name;
        $user->delete();

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => "User {$full_name} has been deleted.",
        ]);

        return to_route('inertia.users.index');
    }
}
