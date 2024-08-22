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
            return route('qet.index');
        }

        $routeMappings = [
            'crud-users' => route('users.index'),
            'access-equipment-import' => route('jobs.index'),
            'access-action-stream' => route('action-stream.index'),
            'create-default-discussions' => route('discussions.create'),
            'update-default-discussions' => route('discussions.edit'),
        ];

        return $routeMappings[$permissions[0]];
    }
}
