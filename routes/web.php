<?php

// use App\Http\Controllers\ProfileController;

use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\OpportunityItemsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionAdministratorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QiOpportunityController;
use App\Http\Controllers\QuarantineIntakeController;
use App\Livewire\ActionStreamIndex;
use App\Livewire\DiscussionsCreate;
use App\Livewire\DiscussionsEdit;
use App\Livewire\JobsIndex;
use App\Livewire\JobsShow;
use App\Livewire\QetIndex;
use App\Livewire\QuarantineIntakeCreate;
use App\Livewire\QuarantineStatsIndex;
use App\Livewire\TechnicalSupervisorsCreate;
use App\Livewire\TechnicalSupervisorsEdit;
use App\Livewire\TechnicalSupervisorsIndex;
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

    Route::get('quarantine-intake', QuarantineIntakeCreate::class)->name('quarantine-intake.create')->middleware('permission:access-quarantine-intake');
    Route::get('quarantine-intake-success', [QuarantineIntakeController::class, 'success'])->name('quarantine-intake-success.index')->middleware('permission:access-quarantine-intake');
    Route::post('quarantine-intake/report-mistake', [QuarantineIntakeController::class, 'reportMistake'])->name('quarantine-intake-report-mistake.store')->middleware('permission:access-quarantine-intake');
    // Route::get('quarantine-stats', QuarantineStatsIndex::class)->name('quarantine-stats.index')->middleware('permission:access-quarantine-stats');

    Route::get('production-administrators', [ProductionAdministratorController::class, 'index'])->name('production-administrators.index')->middleware('permission:crud-production-administrators');
    Route::get('production-administrators/create', [ProductionAdministratorController::class, 'create'])->name('production-administrators.create')->middleware('permission:crud-production-administrators');
    Route::post('production-administrators', [ProductionAdministratorController::class, 'store'])->name('production-administrators.store')->middleware('permission:crud-production-administrators');

    Route::get('technical-supervisors', TechnicalSupervisorsIndex::class)->name('technical-supervisors.index')->middleware('permission:crud-technical-supervisors');
    Route::get('technical-supervisors/create', TechnicalSupervisorsCreate::class)->name('technical-supervisors.create')->middleware('permission:crud-technical-supervisors');
    Route::get('technical-supervisors/{id}/edit', TechnicalSupervisorsEdit::class)->name('technical-supervisors.edit')->middleware('permission:crud-technical-supervisors');

    Route::get('projects/search', [ProjectController::class, 'search'])->name('projects.search');

    Route::get('qi-opportunities/search', [QiOpportunityController::class, 'search'])->name('qi-opportunities.search');

    Route::get('products/search', [ProductController::class, 'search'])->name('products.search');
});

require __DIR__ . '/auth.php';
