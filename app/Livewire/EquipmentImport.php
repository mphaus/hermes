<?php

namespace App\Livewire;

use App\OpportunityItems;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
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
    }

    public function render(): View
    {
        return view('livewire.equipment-import');
    }
}
