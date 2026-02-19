<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Inertia\Inertia;

class NewPasswordController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render('ResetPassword', [
            'name' => 'Reset Password',
            'token' => $request->route('token'),
            'email' => $request->input('email'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                'regex:/^(?=.*[A-Z].*[A-Z])(?=.*[a-z].*[a-z])(?=.*\d.*\d)(?=.*[!@#$%^&*].*[!@#$%^&*]).{16,24}$/',
            ],
        ]);

        $user = Password::getUser(['email' => $request->email]);

        if ($user && !$user->is_enabled) {
            return to_route('password.reset')
                ->withErrors(['email' => __('We were unable to set a new password for you, your account is not enabled or available to set a password.')]);
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PasswordReset) {
            return to_route('password.reset', [
                'token' => $request->input('token'),
                'email' => $request->input('email'),
            ])->withErrors(['email' => __($status)]);
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => __($status),
        ]);

        return Inertia::location(route('login'));
    }
}
