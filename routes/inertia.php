<?php

use App\Http\Controllers\InertiaAuthenticatedSessionController;
use App\Http\Controllers\OpportunitySearchController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\UserIndexController;
use App\Http\Controllers\UsersCreateController;
use App\Http\Controllers\UserStoreController;
use App\Http\Controllers\UsersShowController;
use App\Http\Controllers\UsersEditController;
use App\Http\Middleware\EnsureAdminsAreNotEditingThemselves;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    Route::post('inertia/logout', [InertiaAuthenticatedSessionController::class, 'destroy'])->name('inertia.logout');

    Route::get('inertia/opportunity/search', OpportunitySearchController::class)->name('inertia.opportunity.search');
    Route::get('inertia/product/search', ProductSearchController::class)->name('inertia.product.search');

    Route::get('inertia/users', UserIndexController::class)->name('inertia.users.index')->middleware('permission:crud-users');
    Route::get('inertia/users/create', UsersCreateController::class)->name('inertia.users.create')->middleware('permission:crud-users');
    Route::post('inertia/users', UserStoreController::class)->name('inertia.users.store')->middleware('permission:crud-users');
    Route::get('inertia/users/{user}', UsersShowController::class)->name('inertia.users.show')->middleware('permission:crud-users');
    Route::get('inertia/users/{user}/edit', UsersEditController::class)->name('inertia.users.edit')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);
});
