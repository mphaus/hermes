<?php

// use App\Http\Controllers\ProfileController;

use App\Livewire\ActionStreamIndex;
use App\Livewire\DiscussionsCreate;
use App\Livewire\DiscussionsJsonCreate;
use App\Livewire\JobsIndex;
use App\Livewire\JobsShow;
use App\Livewire\QetIndex;
use App\Livewire\UploadLogsShow;
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
    Route::get('discussion/json-upload', DiscussionsJsonCreate::class)->name('discussions.json.create');
});

require __DIR__ . '/auth.php';
