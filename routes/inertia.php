<?php

use App\Http\Controllers\InertiaAuthenticatedSessionController;
use App\Http\Controllers\OpportunitySearchController;
use App\Http\Controllers\ProductSearchController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {


    Route::post('inertia/logout', [InertiaAuthenticatedSessionController::class, 'destroy'])->name('inertia.logout');

    Route::get('inertia/opportunity/search', OpportunitySearchController::class)->name('inertia.opportunity.search');
    Route::get('inertia/product/search', ProductSearchController::class)->name('inertia.product.search');
});
