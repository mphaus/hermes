<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        /** @var User */
        $user = Auth::user();

        if ($user->username === config('app.super_user.username') || $user->is_admin || in_array($permission, $user->permissions->toArray())) {
            return $next($request);
        }

        abort(404);
    }
}
