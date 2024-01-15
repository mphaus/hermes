<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class CreateApplicationUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = User::firstOrNew(['username' => config('app.mph_user.username')]);

        if ($user->exists === false) {
            $user->first_name = config('app.mph_user.first_name');
            $user->last_name = config('app.mph_user.last_name');
            $user->email = config('app.mph_user.email');
            $user->password = Hash::make(config('app.mph_user.password'));
            $user->save();

            return redirect()->route('login');
        }

        return $next($request);
    }
}
