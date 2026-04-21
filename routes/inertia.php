<?php

use App\Http\Controllers\EquipmentImportIndexController;
use App\Http\Controllers\EquipmentImportShowController;
use App\Http\Controllers\InertiaAuthenticatedSessionController;
use App\Http\Controllers\OpportunitySearchController;
use App\Http\Controllers\ProductSearchController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    Route::post('inertia/logout', [InertiaAuthenticatedSessionController::class, 'destroy'])->name('inertia.logout');

    Route::get('inertia/opportunity/search', OpportunitySearchController::class)->name('inertia.opportunity.search');
    Route::get('inertia/product/search', ProductSearchController::class)->name('inertia.product.search');

    Route::get('inertia/equipment-import', EquipmentImportIndexController::class)
        ->name('inertia.equipment-import')
        ->middleware('permission:access-equipment-import');
    Route::get('inertia/equipment-import/{opportunity_id}', EquipmentImportShowController::class)
        ->name('inertia.equipment-import.show')
        ->middleware('permission:access-equipment-import');
});
