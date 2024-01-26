<?php

// use App\Http\Controllers\ProfileController;

use App\Livewire\Pages\Jobs;
use App\Livewire\Pages\JobsShow;
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

    Route::get('jobs', Jobs::class)->name('jobs');
    Route::get('jobs/{id}', JobsShow::class)->name('jobs.show');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/csv.php';
