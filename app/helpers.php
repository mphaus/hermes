<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('usercan')) {
    function usercan(string $permission)
    {
        $user = Auth::user();
        return $user->username === config('app.super_user.username') || $user->is_admin || in_array($permission, $user->permissions->toArray());
    }
}
