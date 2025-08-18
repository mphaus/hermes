<?php

namespace App\Livewire;

use App\Models\UploadLog as ModelsUploadLog;
use App\OpportunityItems;
use App\UploadLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EquipmentImport extends Component
{
    use WithFileUploads;

    #[Validate('file', message: 'This field must be a file.')]
    #[Validate('max:512', message: 'The :attribute field must not be greater than :max kilobytes.')]
    #[Validate('mimes:csv', message: 'The file must be a file of type: :values.')]
    public $csv;

    #[Locked]
    public int $opportunityid;

    public function save()
    {
        if (!usercan('access-equipment-import')) {
            abort(403);
        }

        if (!$this->csv) {
            throw ValidationException::withMessages(['csv' => __('Please, select a csv file to upload.')]);
        }

        $filename = Arr::join([
            $this->opportunityid,
            now()->setTimezone(config('app.timezone'))->getTimestamp(),
        ], '-', '-') . 'csv';

        $this->csv->storeAs(path: 'csv_files', name: $filename);

        [
            'type' => $type,
            'message' => $message,
            'data' => $data,
        ] = (new OpportunityItems($this->opportunityid, $filename))->process();

        if ($type === 'error') {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => $message,
            ]);

            return $this->redirectRoute(name: 'jobs.show', parameters: ['id' => $this->opportunityid]);
        }

        ['log' => $log, 'diff' => $diff, 'opportunity' => $opportunity] = $data;

        if (empty($log)) {
            session()->flash('alert', [
                'type' => 'warning',
                'message' => __('The data was uploaded and processed. However no changes were made.'),
            ]);

            return $this->redirectRoute(name: 'jobs.show', parameters: ['id' => $this->opportunityid]);
        }

        if ($diff) {
            $response = Http::current()->withQueryParameters([
                'q[discussable_id_eq]' => $this->opportunityid,
                'q[subject_cont]' => 'Job status',
                'per_page' => 1,
            ])->get('discussions');

            if ($response->successful()) {
                ['discussions' => $discussions] = $response->json();

                /**
                 * @var array $discussions
                 */

                if ($discussions) {
                    if (ModelsUploadLog::where('job_id', $this->opportunityid)->count() === 0) {
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

            return $this->redirectRoute(name: 'jobs.show', parameters: ['id' => $this->opportunityid]);
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('The data was uploaded and processed successfully.'),
        ]);

        return $this->redirectRoute(name: 'jobs.show', parameters: ['id' => $this->opportunityid]);
    }

    public function render(): View
    {
        return view('livewire.equipment-import');
    }
}
