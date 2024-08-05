<?php

// use App\Http\Controllers\ProfileController;

use App\Http\Controllers\OpportunityController;
use App\Livewire\ActionStreamIndex;
use App\Livewire\DiscussionsCreate;
use App\Livewire\DiscussionsEdit;
use App\Livewire\JobsIndex;
use App\Livewire\JobsShow;
use App\Livewire\QetIndex;
use App\Livewire\UploadLogsShow;
use App\Livewire\UsersCreate;
use App\Livewire\UsersIndex;
use App\Livewire\UsersShow;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('equipment-import', JobsIndex::class)->name('jobs.index');
    Route::permanentRedirect('/jobs', '/equipment-import');

    Route::get('equipment-import/{id}', JobsShow::class)->name('jobs.show');
    Route::permanentRedirect('/jobs/{id}', '/equipment-import/{id}');

    Route::get('logs/{id}', UploadLogsShow::class)->name('logs.show');
    Route::get('action-stream', ActionStreamIndex::class)->name('action-stream.index');
    Route::get('qet', QetIndex::class)->name('qet.index');

    Route::get('discussions/create', DiscussionsCreate::class)->name('discussions.create');
    Route::get('discussions/edit', DiscussionsEdit::class)->name('discussions.edit');

    Route::get('opportunities/search', [OpportunityController::class, 'search'])->name('opportunities.search');
    Route::get('opportunities/{id}', [OpportunityController::class, 'show'])->name('opportunities.show');

    Route::get('users', UsersIndex::class)->name('users.index');
    Route::get('users/create', UsersCreate::class)->name('users.create');
    Route::get('users/{user}', UsersShow::class)->name('users.show');
});

require __DIR__ . '/auth.php';
