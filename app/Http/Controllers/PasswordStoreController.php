<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordStoreRequest;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PasswordStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(PasswordStoreRequest $request)
    {
        $request->store();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('alert', [
            'type' => 'success',
            'message' => 'Your password has been reset successfully. Please log in with your new password.',
        ]);

        return Inertia::location(route('login'));
    }
}
