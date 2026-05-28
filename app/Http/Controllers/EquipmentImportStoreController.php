<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentImportRequest;
use Illuminate\Support\Facades\Storage;

class EquipmentImportStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreEquipmentImportRequest $request)
    {
        ['opportunity_id' => $opportunity_id] = $request->validated();

        $filename = sprintf('%s-%s.csv', $opportunity_id, now()->setTimezone(config('app.timezone'))->getTimestamp());

        $stored = Storage::disk('local')->putFileAs(
            path: 'csv_files',
            file: $request->file('csv_file'),
            name: $filename,
        );

        if ($stored === false) {
            return back(status: 303)->withErrors([
                'csv_file' => __('The csv file could not be stored. Please try again.'),
            ]);
        }

        dd("Success");
    }
}
