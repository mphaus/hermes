<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentImportRequest;
use App\OpportunityItems;
use App\UploadLog;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class OpportunityItemsController extends Controller
{
    public function store(EquipmentImportRequest $request)
    {
        ['opportunity_id' => $opportunity_id, 'csv' => $csv] = $request->validated();

        /**
         * @var int $opportunity_id
         */

        $response = Http::current()->get("opportunities/{$opportunity_id}?include[]=opportunity_items");

        if ($response->failed()) {
            return response()->json([
                'type' => 'error',
                'message' => __('An error occurred while attempting to process the data from the uploaded file. Please refresh the page, and try again.'),
            ], 400);
        }

        ['opportunity' => $opportunity] = $response->json();

        /**
         * @var string $filename
         */
        $filename = Arr::join([
            $opportunity['id'],
            now()->setTimezone(config('app.timezone'))->getTimestamp(),
            str()->slug($opportunity['subject']),
        ], '-', '-') . '.csv';

        /**
         * @var \Illuminate\Http\UploadedFile $csv
         */

        $csv->storeAs(path: 'csv_files', name: $filename);

        /**
         * @var array $opportunity
         */

        $opportunity_items_process = (new OpportunityItems($opportunity, $filename))->process();

        if (empty($opportunity_items_process)) {
            session()->flash('alert', [
                'type' => 'warning',
                'message' =>  __('The data was uploaded and processed. However no changes were made.'),
            ]);

            return response()->json([
                'redirect_to' => route('jobs.show', ['id' => $opportunity['id']]),
            ]);
        }

        $upload_log = new UploadLog($opportunity['id'], $opportunity_items_process);
        $upload_log->save();

        if ($upload_log->getStatus() !== 'successful') {
            session()->flash('alert', [
                'type' => 'warning',
                'message' => __('The data was uploaded and processed with warnings. Please check the most recent entry of the log.'),
            ]);

            return response()->json([
                'redirect_to' => route('jobs.show', ['id' => $opportunity['id']]),
            ]);
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('The data was uploaded and processed successfully.'),
        ]);

        return response()->json([
            'redirect_to' => route('jobs.show', ['id' => $opportunity['id']]),
        ]);
    }
}
