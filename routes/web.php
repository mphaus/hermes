<?php

// use App\Http\Controllers\ProfileController;

use App\Livewire\ActionStreamIndex;
use App\Livewire\JobsIndex;
use App\Livewire\JobsShow;
use App\Livewire\QetIndex;
use App\Livewire\UploadLogsShow;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('jobs', JobsIndex::class)->name('jobs.index');
    Route::get('jobs/{id}', JobsShow::class)->name('jobs.show');
    Route::get('logs/{id}', UploadLogsShow::class)->name('logs.show');
    Route::get('action-stream', ActionStreamIndex::class)->name('action-stream.index');
    Route::get('qet', QetIndex::class)->name('qet.index');
});

require __DIR__ . '/auth.php';
