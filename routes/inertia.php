<?php

use App\Http\Controllers\EquipmentImportIndexController;
use App\Http\Controllers\EquipmentImportShowController;
use App\Http\Controllers\EquipmentImportStoreController;
use App\Http\Controllers\InertiaAuthenticatedSessionController;
use App\Http\Controllers\OpportunitySearchController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Middleware\EnsureIsLocalEnvironment;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    Route::post('inertia/logout', [InertiaAuthenticatedSessionController::class, 'destroy'])->name('inertia.logout');

    Route::get('inertia/opportunity/search', OpportunitySearchController::class)->name('inertia.opportunity.search');
    Route::get('inertia/product/search', ProductSearchController::class)->name('inertia.product.search');

    Route::middleware(EnsureIsLocalEnvironment::class)->prefix('inertia')->group(function () {
        Route::get('equipment-import', EquipmentImportIndexController::class)
            ->name('inertia.equipment-import')
            ->middleware('permission:access-equipment-import');
        Route::get('equipment-import/{opportunity_id}', EquipmentImportShowController::class)
            ->name('inertia.equipment-import.show')
            ->middleware('permission:access-equipment-import');
        Route::post('equipment-import', EquipmentImportStoreController::class)
            ->name('inertia.equipment-import.store')
            ->middleware('permission:access-equipment-import');
    });
});
