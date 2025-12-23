<?php

use App\Http\Controllers\InertiaAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'is_enabled'])->group(function () {
    Route::get('inertia/quarantine/create', function () {
        return Inertia::render('QuarantineCreate', [
            'title' => __('Quarantine Intake'),
            'description' => __('Refer to the <a href=":url_1" target="_blank" rel="nofollow" title="Add Product to Quarantine via Hermes section">Add Product to Quarantine via Hermes section</a> of the Quarantine Intake Process for detailed instructions. Check out what\'s already in <a href=":url_2" target="_blank" rel="nofollow">Quarantine in CurrentRMS</a> (this is available to full-time MPH staff, and casuals in the warehouse via the computer at the Quarantine Intake desk). ', ['url_1' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/01%20In%20development/Process_%20Repairs%20Quarantine%20intake.docx?d=wc450b4cdc2e84c758363390091b56915&csf=1&web=1&e=BkqZrw&nav=eyJoIjoiMjAwNzMzMjA1NyJ9', 'url_2' => 'https://mphaustralia.current-rms.com/quarantines']),
        ]);
    })->middleware('permission:access-quarantine-intake');

    Route::post('inertia/logout', [InertiaAuthenticatedSessionController::class, 'destroy'])->name('inertia.logout');
});
