<?php

use App\Http\Controllers\InertiaAuthenticatedSessionController;
use App\Http\Controllers\QuarantineCreateController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    Route::get('inertia/quarantine/create', QuarantineCreateController::class)->middleware('permission:access-quarantine-intake');
    Route::post('inertia/logout', [InertiaAuthenticatedSessionController::class, 'destroy'])->name('inertia.logout');
});
