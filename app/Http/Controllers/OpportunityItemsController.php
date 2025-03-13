<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipmentImportRequest;
use App\Models\UploadLog as ModelsUploadLog;
use App\OpportunityItems;
use App\UploadLog;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
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

        ['log' => $log, 'diff' => $diff] = (new OpportunityItems($opportunity, $filename))->process();

        /**
         * @var array $log
         */

        if (empty($log)) {
            session()->flash('alert', [
                'type' => 'warning',
                'message' =>  __('The data was uploaded and processed. However no changes were made.'),
            ]);

            return response()->json([
                'redirect_to' => route('jobs.show', ['id' => $opportunity['id']]),
            ]);
        }

        if ($diff) {
            $response = Http::current()->withQueryParameters([
                'q[discussable_id_eq]' => $opportunity_id,
                'q[subject_cont]' => 'Job status',
                'per_page' => 1,
            ])->get('discussions');

            if ($response->successful()) {
                ['discussions' => $discussions] = $response->json();

                /**
                 * @var array $discussions
                 */

                if ($discussions) {
                    if (ModelsUploadLog::where('job_id', $opportunity_id)->count() === 0) {
                        $remark = __('Initial equipment list import completed');
                    } else {
                        $remark = __(':username did a new Equipment Import for this Job. There changes were;', ['username' => Auth::user()->username]);
                        $remark .= PHP_EOL . PHP_EOL;
                        $remark .= '<ul>';

                        foreach ($diff as $action => $items) {
                            if (empty($items)) {
                                continue;
                            }

                            $count = count($items);

                            switch ($action) {
                                case 'reduced':
                                    $remark .= '<li>';
                                    $remark .= __(':count :product with <strong>:action</strong> counts (:final_sentence)', [
                                        'count' => $count,
                                        'product' => $count === 1 ? __('Product') : __('Products'),
                                        'action' => $action,
                                        'final_sentence' => $count === 1 ? __('fewer of this are required') : __('fewer of these are required')
                                    ]);
                                    $remark .= '<ul>';

                                    foreach ($items as $item) {
                                        $remark .= __('<li>Now, only :quantity x :item_name :present_tense required</li>', [
                                            'quantity' => $item['quantity'],
                                            'item_name' => $item['item_name'],
                                            'present_tense' => $count === 1 ? __('is') : __('are'),
                                        ]);
                                    }

                                    $remark .= '</ul>';
                                    $remark .= '</li>';
                                    break;
                                case 'increased':
                                    $remark .= '<li>';
                                    $remark .= __(':count :product with <strong>:action</strong> counts (:final_sentence)', [
                                        'count' => $count,
                                        'product' => $count === 1 ? __('Product') : __('Products'),
                                        'action' => $action,
                                        'final_sentence' => $count === 1 ? __('more of this are required') : __('more of these are required'),
                                    ]);
                                    $remark .= '<ul>';

                                    foreach ($items as $item) {
                                        $remark .= __('<li>:added_quantity x :item_name were added (now :quantity are required)</li>', [
                                            'added_quantity' => $item['added_quantity'],
                                            'item_name' => $item['item_name'],
                                            'quantity' => $item['quantity'],
                                        ]);
                                    }

                                    $remark .= '</ul>';
                                    $remark .= '</li>';
                                    break;
                                case 'removed':
                                    $remark .= '<li>';
                                    $remark .= __(':count :product :past_tense <strong>:action</strong> (none of these are required now)', [
                                        'count' => $count,
                                        'product' => $count === 1 ? __('Product') : __('Products'),
                                        'action' => $action,
                                        'past_tense' => $count === 1 ? __('was') : __('were'),
                                    ]);
                                    $remark .= '<ul>';

                                    foreach ($items as $item) {
                                        $remark .= __('<li>No :item_name are required now</li>', ['item_name' => $item['item_name']]);
                                    }

                                    $remark .= '</ul>';
                                    $remark .= '</li>';
                                    break;
                                case 'added':
                                    $remark .= '<li>';
                                    $remark .= __(':count :product :past_tense <strong>:action</strong> (:final_sentence)', [
                                        'count' => $count,
                                        'product' => $count === 1 ? __('Product') : __('Products'),
                                        'past_tense' => $count === 1 ? __('was') : __('were'),
                                        'action' => $action,
                                        'final_sentence' => $count === 1 ? __('it was not present before') : __('they were not present before')
                                    ]);
                                    $remark .= '<ul>';

                                    foreach ($items as $item) {
                                        $remark .= __('<li>:quantity x :item_name :perfect_present been added</li>', [
                                            'quantity' => $item['quantity'],
                                            'item_name' => $item['item_name'],
                                            'perfect_present' => $count === 1 ? __('has') : __('have')
                                        ]);
                                    }

                                    $remark .= '</ul>';
                                    $remark .= '</li>';
                                    break;
                            }
                        }

                        $remark .= '</ul>';
                    }

                    Http::current()->post("discussions/{$discussions[0]['id']}/comments", [
                        'discussion_id' => $discussions[0]['id'],
                        'remark' => $remark,
                        'html' => true,
                        'created_by' => $opportunity['owned_by'],
                    ]);
                }
            }
        }

        $upload_log = new UploadLog($opportunity['id'], $log);
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
