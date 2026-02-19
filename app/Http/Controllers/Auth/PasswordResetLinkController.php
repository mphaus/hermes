<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return Inertia::render('ForgotPassword', [
            'title' => 'Forgot your password?',
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = Password::getUser(['email' => $request->email]);

        if ($user && !$user->is_enabled) {
            return to_route('password.request')->withErrors([
                'email' => 'We were unable to send you a link to reset your password, your account is not enabled or available to use the password recovery feature.'
            ]);
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::ResetLinkSent
            ? to_route('password.request')->with('status', __($status))
            : to_route('password.request')->withErrors(['email' => __($status)]);
    }
}
