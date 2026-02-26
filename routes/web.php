<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\PasswordStoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductionAdministratorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuarantineCreateController;
use App\Http\Controllers\QuarantineReportMistakeController;
use App\Http\Controllers\QuarantineStoreController;
use App\Http\Controllers\QuarantineSuccessController;
use App\Http\Controllers\TechnicalSupervisorController;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

    Route::get('i/technical-supervisors', [TechnicalSupervisorController::class, 'index'])->name('technical-supervisors.index')->middleware('permission:crud-technical-supervisors');
    Route::post('i/technical-supervisors', [TechnicalSupervisorController::class, 'store'])->name('technical-supervisors.store')->middleware('permission:crud-technical-supervisors');
    Route::get('i/technical-supervisors/{id}', [TechnicalSupervisorController::class, 'show'])->name('technical-supervisors.show')->middleware('permission:crud-technical-supervisors');
    Route::put('i/technical-supervisors/{id}', [TechnicalSupervisorController::class, 'update'])->name('technical-supervisors.update')->middleware('permission:crud-technical-supervisors');

    Route::get('i/projects/search', [ProjectController::class, 'search'])->name('projects.search');
    Route::get('i/products/search', [ProductController::class, 'search'])->name('products.search');

    Route::get('i/members/search', [MemberController::class, 'search'])->name('members.search')->middleware('permission:create-default-discussions');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/inertia.php';
