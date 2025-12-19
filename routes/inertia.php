<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('inertia/home', function () {
    return Inertia::render('Home');
});
