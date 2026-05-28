<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEquipmentImportRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class EquipmentImportStoreController extends Controller
{
    private array $required_headings = ['id', 'item_name', 'quantity', 'group_name'];

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

        $path = Storage::disk('local')->path($stored);
        $handle = fopen($path, 'r');

        if ($handle === false) {
            Storage::disk('local')->delete($stored);

            return back(status: 303)->withErrors([
                'csv_file' => __('The csv file could not be read. Please try again.'),
            ]);
        }

        $headings = fgetcsv($handle, 1000, ',');
        fclose($handle);

        if ($headings === false) {
            Storage::disk('local')->delete($stored);

            return back(status: 303)->withErrors([
                'csv_file' => __('The uploaded csv file is empty or invalid.'),
            ]);
        }

        $missing_headings = array_diff($this->required_headings, $headings);

        if (count($missing_headings) > 0) {
            Storage::disk('local')->delete($stored);
            $missing_headings_text = Arr::join($missing_headings, ', ', ' and ');

            return back(status: 303)->withErrors([
                'csv_file' => __('The uploaded csv file does not contain the valid headings required to identify the items. Missing headings: :missing_headings.', ['missing_headings' => $missing_headings_text]),
            ]);
        }

        dd("Success");
    }
}
