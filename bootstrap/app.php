<?php

use App\Http\Middleware\CreateApplicationSuperUser;
use App\Http\Middleware\EnsureUserHasPermission;
use App\Http\Middleware\EnsureUserIsEnabled;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_enabled' => EnsureUserIsEnabled::class,
            'permission' => EnsureUserHasPermission::class,
        ]);

        $middleware->append([
            HandleInertiaRequests::class,
            CreateApplicationSuperUser::class,
        ]);
        $middleware->redirectGuestsTo(fn() => route('login'));
        $middleware->redirectUsersTo(fn() => get_redirect_route());
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
