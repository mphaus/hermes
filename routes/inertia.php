<?php

use App\Http\Controllers\InertiaAuthenticatedSessionController;
use App\Http\Controllers\OpportunitySearchController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\UserIndexController;
use App\Http\Controllers\UserCreateController;
use App\Http\Controllers\UserStoreController;
use App\Http\Controllers\UserShowController;
use App\Http\Controllers\UserEditController;
use App\Http\Controllers\UserUpdateController;
use App\Http\Controllers\UserDestroyController;
use App\Http\Middleware\EnsureAdminsAreNotEditingThemselves;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    Route::post('inertia/logout', [InertiaAuthenticatedSessionController::class, 'destroy'])->name('inertia.logout');

    Route::get('inertia/opportunity/search', OpportunitySearchController::class)->name('inertia.opportunity.search');
    Route::get('inertia/product/search', ProductSearchController::class)->name('inertia.product.search');

    Route::get('inertia/users', UserIndexController::class)->name('inertia.users.index')->middleware('permission:crud-users');
    Route::get('inertia/users/create', UserCreateController::class)->name('inertia.users.create')->middleware('permission:crud-users');
    Route::post('inertia/users', UserStoreController::class)->name('inertia.users.store')->middleware('permission:crud-users');
    Route::get('inertia/users/{user}', UserShowController::class)->name('inertia.users.show')->middleware('permission:crud-users');
    Route::get('inertia/users/{user}/edit', UserEditController::class)->name('inertia.users.edit')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);
    Route::put('inertia/users/{user}', UserUpdateController::class)->name('inertia.users.update')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);
    Route::delete('inertia/users/{user}', UserDestroyController::class)->name('inertia.users.destroy')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);
});
