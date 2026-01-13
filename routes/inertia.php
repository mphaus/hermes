<?php

use App\Http\Controllers\InertiaAuthenticatedSessionController;
use App\Http\Controllers\OpportunitySearchController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\QuarantineCreateController;
use App\Http\Controllers\StoreQuarantineController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    Route::get('inertia/quarantine/create', QuarantineCreateController::class)->middleware('permission:access-quarantine-intake')->name('quarantine.create');
    Route::post('inertia/quarantine', StoreQuarantineController::class)->middleware([
        'permission:access-quarantine-intake',
        HandlePrecognitiveRequests::class,
    ]);

    Route::post('inertia/logout', [InertiaAuthenticatedSessionController::class, 'destroy'])->name('inertia.logout');

    Route::get('inertia/opportunity/search', OpportunitySearchController::class)->name('inertia.opportunity.search');
    Route::get('inertia/product/search', ProductSearchController::class)->name('inertia.product.search');
});
