<?php

namespace App\Http\Middleware;

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
        if ($request->isXmlHttpRequest() && $request->headers->get('referer') === route('quarantine.create.view') && $permission === 'crud-technical-supervisors') {
            return $next($request);
        }

        if (usercan($permission)) {
            return $next($request);
        }

        abort(404);
    }
}
