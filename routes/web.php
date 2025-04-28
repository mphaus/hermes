<?php

// use App\Http\Controllers\ProfileController;

use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\OpportunityItemsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionAdministratorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QiOpportunityController;
use App\Http\Controllers\QuarantineCheckSerialNumberController;
use App\Http\Controllers\QuarantineController;
use App\Http\Controllers\TechnicalSupervisorController;
use App\Livewire\ActionStreamIndex;
use App\Livewire\DiscussionsCreate;
use App\Livewire\DiscussionsEdit;
use App\Livewire\JobsIndex;
use App\Livewire\JobsShow;
use App\Livewire\QetIndex;
use App\Livewire\UploadLogsShow;
use App\Livewire\UsersCreate;
use App\Livewire\UsersEdit;
use App\Livewire\UsersIndex;
use App\Livewire\UsersShow;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('equipment-import', JobsIndex::class)->name('jobs.index')->middleware('permission:access-equipment-import');
    Route::permanentRedirect('/jobs', '/equipment-import');

    Route::get('equipment-import/{id}', JobsShow::class)->name('jobs.show')->middleware('permission:access-equipment-import');
    Route::permanentRedirect('/jobs/{id}', '/equipment-import/{id}');

    Route::post('opportunity-items', [OpportunityItemsController::class, 'store'])->middleware('permission:access-equipment-import')->name('opportunity-items.store');

    Route::get('logs/{id}', UploadLogsShow::class)->name('logs.show')->middleware('permission:access-equipment-import');
    Route::get('action-stream', ActionStreamIndex::class)->name('action-stream.index')->middleware('permission:access-action-stream');
    Route::get('qet', QetIndex::class)->name('qet.index')->middleware('permission:access-qet');

    Route::get('discussions/create', DiscussionsCreate::class)->name('discussions.create')->middleware('permission:create-default-discussions');
    Route::get('discussions/edit', DiscussionsEdit::class)->name('discussions.edit')->middleware('permission:update-default-discussions');

    Route::get('opportunities/search', [OpportunityController::class, 'search'])->name('opportunities.search');
    Route::get('opportunities/{id}', [OpportunityController::class, 'show'])->name('opportunities.show');

    Route::get('users', UsersIndex::class)->name('users.index')->middleware('permission:crud-users');
    Route::get('users/create', UsersCreate::class)->name('users.create')->middleware('permission:crud-users');
    Route::get('users/{user}', UsersShow::class)->name('users.show')->middleware('permission:crud-users');
    Route::get('users/{user}/edit', UsersEdit::class)->name('users.edit')->middleware('permission:crud-users');

    Route::view('quarantine/create', 'quarantine.create')->name('quarantine.create.view')->middleware('permission:access-quarantine-intake');
    Route::permanentRedirect('/quarantine-intake', '/quarantine/create');
    Route::get('quarantine/success', [QuarantineController::class, 'success'])->name('quarantine.success.index')->middleware('permission:access-quarantine-intake');
    Route::post('quarantine/report-mistake', [QuarantineController::class, 'storeReport'])->name('quarantine.report-mistake.store')->middleware('permission:access-quarantine-intake');

    Route::post('i/quarantine', [QuarantineController::class, 'store'])->name('quarantine.store')->middleware('permission:access-quarantine-intake');
    Route::post('i/quarantine/check-serial-number', QuarantineCheckSerialNumberController::class)->name('quarantine.check-serial-number')->middleware('permission:access-quarantine-intake');

    Route::view('production-administrators', 'production-administrator.index')->name('production-administrators.index.view')->middleware('permission:crud-production-administrators');
    Route::view('production-administrators/create', 'production-administrator.create')->name('production-administrators.create.view')->middleware('permission:crud-production-administrators');
    Route::view('production-administrators/{id}/edit', 'production-administrator.edit')->name('production-administrators.edit.view')->middleware('permission:crud-production-administrators');

    Route::get('i/production-administrators', [ProductionAdministratorController::class, 'index'])->name('production-administrators.index')->middleware('permission:crud-production-administrators');
    Route::post('i/production-administrators', [ProductionAdministratorController::class, 'store'])->name('production-administrators.store')->middleware('permission:crud-production-administrators');
    Route::get('i/production-administrators/{id}', [ProductionAdministratorController::class, 'show'])->name('production-administrators.show')->middleware('permission:crud-production-administrators');
    Route::put('i/production-administrators/{id}', [ProductionAdministratorController::class, 'update'])->name('production-administrators.update')->middleware('permission:crud-production-administrators');

    Route::view('technical-supervisors', 'technical-supervisor.index')->name('technical-supervisors.index.view')->middleware('permission:crud-technical-supervisors');
    Route::view('technical-supervisors/create', 'technical-supervisor.create')->name('technical-supervisors.create.view')->middleware('permission:crud-technical-supervisors');
    Route::view('technical-supervisors/{id}/edit', 'technical-supervisor.edit')->name('technical-supervisors.edit.view')->middleware('permission:crud-technical-supervisors');

    Route::get('i/technical-supervisors', [TechnicalSupervisorController::class, 'index'])->name('technical-supervisors.index')->middleware('permission:crud-technical-supervisors');
    Route::post('i/technical-supervisors', [TechnicalSupervisorController::class, 'store'])->name('technical-supervisors.store')->middleware('permission:crud-technical-supervisors');
    Route::get('i/technical-supervisors/{id}', [TechnicalSupervisorController::class, 'show'])->name('technical-supervisors.show')->middleware('permission:crud-technical-supervisors');
    Route::put('i/technical-supervisors/{id}', [TechnicalSupervisorController::class, 'update'])->name('technical-supervisors.update')->middleware('permission:crud-technical-supervisors');

    Route::get('projects/search', [ProjectController::class, 'search'])->name('projects.search');

    Route::get('qi-opportunities/search', [QiOpportunityController::class, 'search'])->name('qi-opportunities.search');

    Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
});

require __DIR__ . '/auth.php';
