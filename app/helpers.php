<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('usercan')) {
    function usercan(string $permission)
    {
        $user = Auth::user();
        return $user->username === config('app.super_user.username') || $user->is_admin || in_array($permission, $user->permissions->toArray());
    }
}

if (!function_exists('get_redirect_route')) {
    function get_redirect_route()
    {
        $user = Auth::user();

        if ($user->username === config('app.super_user.username') || $user->is_admin) {
            return route('jobs.index');
        }

        $permissions = $user->permissions->toArray();

        if (empty($permissions)) {
            Auth::guard('web')->logout();

            request()->session()->invalidate();
            request()->session()->regenerateToken();

            return route('login');
        }

        $routeMappings = [
            'access-equipment-import' => route('jobs.index'),
            'access-action-stream' => route('action-stream.index'),
            'access-qet' => route('qet.index'),
            'create-default-discussions' => route('discussions.create'),
            'update-default-discussions' => route('discussions.edit'),
            'access-quarantine-intake' => route('quarantine-intake.create'),
            'crud-technical-supervisors' => route('technical-supervisors.index'),
            'crud-users' => route('users.index'),
        ];

        return $routeMappings[$permissions[0]];
    }
}
