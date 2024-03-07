<?php

namespace App\Livewire;

use App\Facades\OpportunityItems;
use App\Facades\UploadLog;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ItemsCreate extends Component
{
    use WithFileUploads;

    #[Validate('file', message: 'This field must be a file.')]
    #[Validate('max:512', message: 'The :attribute field must not be greater than :max kilobytes.')]
    #[Validate('mimes:csv', message: 'The file must be a file of type: :values.')]
    public $csvfile;

    #[Locked]
    public int $jobId;

    public function mount(int $jobId): void
    {
        $this->jobId = $jobId;
    }

    public function save(): mixed
    {
        if (!$this->csvfile) {
            throw ValidationException::withMessages(['csvfile' => __('Please, select a csv file to upload.')]);
        }

        sleep(10);
        $this->dispatch('items-created')->self();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('The data was uploaded and processed successfully.'),
        ]);

        return $this->redirectRoute('jobs.show', ['id' => config('app.mph_test_opportunity_id')], navigate: true);

        // GET MOST UPDATED VERSION OF JOB HERE
        $response = Http::current()->get("opportunities/{$this->jobId}?include[]=opportunity_items");

        if ($response->failed()) {
            session()->flash('alert', [
                'type' => 'danger',
                'message' => __('An error occurred while attempting to process the data from the uploaded file. Please, try again.'),
            ]);

            return $this->redirectRoute('jobs.show', ['id' => $this->jobId], navigate: true);
        }

        ['opportunity' => $job] = $response->json();

        $filename = Arr::join([
            $job['id'],
            now()->setTimezone(config('app.timezone'))->getTimestamp(),
            str()->slug($job['subject']),
        ], '-', '-') . '.csv';

        $this->csvfile->storeAs(path: 'csv_files', name: $filename);

        $uploadLog = OpportunityItems::process($job, $filename);

        if (empty($uploadLog)) {
            session()->flash('alert', [
                'type' => 'success',
                'message' => __('The data was uploaded and processed. However no changes were made.'),
            ]);

            return $this->redirectRoute('jobs.show', ['id' => $job['id']], navigate: true);
        }

        UploadLog::save($job['id'], $uploadLog);

        if (UploadLog::getStatus($uploadLog) !== 'successful') {
            session()->flash('alert', [
                'type' => 'warning',
                'message' => __('The data was uploaded and processed with warnings. Please check the most recent entry of the log.'),
            ]);

            return $this->redirectRoute('jobs.show', ['id' => $job['id']], navigate: true);
        }

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('The data was uploaded and processed successfully.'),
        ]);

        $this->dispatch('items-created')->self();

        return $this->redirectRoute('jobs.show', ['id' => $job['id']], navigate: true);
    }

    public function render(): View
    {
        return view('livewire.items-create');
    }
}
