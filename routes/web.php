<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\PasswordStoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionAdministratorController;
use App\Http\Controllers\ProductionAdministratorCreateController;
use App\Http\Controllers\ProductionAdministratorEditController;
use App\Http\Controllers\ProductionAdministratorIndexController;
use App\Http\Controllers\ProductionAdministratorStoreController;
use App\Http\Controllers\ProductionAdministratorUpdateController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuarantineCreateController;
use App\Http\Controllers\QuarantineReportMistakeController;
use App\Http\Controllers\QuarantineStoreController;
use App\Http\Controllers\QuarantineSuccessController;
use App\Http\Controllers\TechnicalSupervisorCreateController;
use App\Http\Controllers\TechnicalSupervisorEditController;
use App\Http\Controllers\TechnicalSupervisorIndexController;
use App\Http\Controllers\TechnicalSupervisorStoreController;
use App\Http\Controllers\TechnicalSupervisorUpdateController;
use App\Http\Controllers\UserChangePasswordController;
use App\Http\Controllers\UserCreateController;
use App\Http\Controllers\UserDestroyController;
use App\Http\Controllers\UserEditController;
use App\Http\Controllers\UserIndexController;
use App\Http\Controllers\UserShowController;
use App\Http\Controllers\UserStoreController;
use App\Http\Controllers\UserUpdateController;
use App\Http\Controllers\UserUpdatePasswordController;
use App\Http\Middleware\EnsureAdminsAreNotEditingThemselves;
use App\Livewire\ActionStreamIndex;
use App\Livewire\DiscussionsCreate;
use App\Livewire\DiscussionsEdit;
use App\Livewire\JobsIndex;
use App\Livewire\JobsShow;
use App\Livewire\QetIndex;
use App\Livewire\UploadLogsShow;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    Route::get('change-password', ChangePasswordController::class)->name('change-password');
    Route::post('change-password', PasswordStoreController::class)->name('change-password.store');

    Route::get('equipment-import', JobsIndex::class)->name('jobs.index')->middleware('permission:access-equipment-import');
    Route::permanentRedirect('/jobs', '/equipment-import');

    Route::get('equipment-import/{id}', JobsShow::class)->name('jobs.show')->middleware('permission:access-equipment-import');
    Route::permanentRedirect('/jobs/{id}', '/equipment-import/{id}');

    Route::get('logs/{id}', UploadLogsShow::class)->name('logs.show')->middleware('permission:access-equipment-import');
    Route::get('action-stream', ActionStreamIndex::class)->name('action-stream.index')->middleware('permission:access-action-stream');
    Route::get('qet', QetIndex::class)->name('qet.index')->middleware('permission:access-qet');

    Route::get('discussions/create', DiscussionsCreate::class)->name('discussions.create')->middleware('permission:create-default-discussions');
    Route::get('discussions/edit', DiscussionsEdit::class)->name('discussions.edit')->middleware('permission:update-default-discussions');

    Route::get('opportunities/search', [OpportunityController::class, 'search'])->name('opportunities.search');
    Route::get('opportunities/{id}', [OpportunityController::class, 'show'])->name('opportunities.show');

    Route::get('quarantine/create', QuarantineCreateController::class)->middleware('permission:access-quarantine-intake')->name('quarantine.create');
    Route::post('quarantine', QuarantineStoreController::class)->middleware([
        'permission:access-quarantine-intake',
        HandlePrecognitiveRequests::class,
    ]);
    Route::get('quarantine/success', QuarantineSuccessController::class)->name('quarantine.success')->middleware('permission:access-quarantine-intake');
    Route::post('quarantine/report-mistake', QuarantineReportMistakeController::class)->name('quarantine.report-mistake')->middleware('permission:access-quarantine-intake');

    Route::get('production-administrators', ProductionAdministratorIndexController::class)->name('production-administrators.index')->middleware('permission:crud-production-administrators');
    Route::get('production-administrators/create', ProductionAdministratorCreateController::class)->name('production-administrators.create')->middleware('permission:crud-production-administrators');
    Route::post('production-administrators', ProductionAdministratorStoreController::class)->name('production-administrators.store')->middleware('permission:crud-production-administrators');
    Route::get('production-administrators/{id}/edit', ProductionAdministratorEditController::class)->name('production-administrators.edit')->middleware('permission:crud-production-administrators');
    Route::put('production-administrators/{id}', ProductionAdministratorUpdateController::class)->name('production-administrators.update')->middleware('permission:crud-production-administrators');

    Route::get('technical-supervisors', TechnicalSupervisorIndexController::class)->name('technical-supervisors.index')->middleware('permission:crud-technical-supervisors');
    Route::get('technical-supervisors/create', TechnicalSupervisorCreateController::class)->name('technical-supervisors.create')->middleware('permission:crud-technical-supervisors');
    Route::post('technical-supervisors', TechnicalSupervisorStoreController::class)->name('technical-supervisors.store');
    Route::get('technical-supervisors/{id}/edit', TechnicalSupervisorEditController::class)->name('technical-supervisors.edit')->middleware('permission:crud-technical-supervisors');
    Route::put('technical-supervisors/{id}', TechnicalSupervisorUpdateController::class)->name('technical-supervisors.update');

    Route::get('users', UserIndexController::class)->name('users.index')->middleware('permission:crud-users');
    Route::get('users/create', UserCreateController::class)->name('users.create')->middleware('permission:crud-users');
    Route::post('users', UserStoreController::class)->name('users.store')->middleware('permission:crud-users');
    Route::get('users/{user}', UserShowController::class)->name('users.show')->middleware('permission:crud-users');
    Route::get('users/{user}/edit', UserEditController::class)->name('users.edit')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);

    Route::put('users/{user}', UserUpdateController::class)->name('users.update')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);

    Route::delete('users/{user}', UserDestroyController::class)->name('users.destroy')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);

    Route::get('users/{user}/change-password', UserChangePasswordController::class)->name('users.change-password')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);

    Route::put('users/{user}/change-password', UserUpdatePasswordController::class)->name('users.change-password.update')->middleware([
        'permission:crud-users',
        EnsureAdminsAreNotEditingThemselves::class,
    ]);

    Route::get('i/projects/search', [ProjectController::class, 'search'])->name('projects.search');
    Route::get('i/products/search', [ProductController::class, 'search'])->name('products.search');

    Route::get('i/members/search', [MemberController::class, 'search'])->name('members.search')->middleware('permission:create-default-discussions');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/inertia.php';
