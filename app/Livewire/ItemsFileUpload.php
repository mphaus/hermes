<?php

namespace App\Livewire;

use App\ItemsProcess;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ItemsFileUpload extends Component
{
    use WithFileUploads;


    #[Validate('file', message: 'This field must be a file.')]
    #[Validate('max:512', message: 'The :attribute field must not be greater than :max kilobytes.')]
    #[Validate('mimes:csv', message: 'The file must be a file of type: :values.')]
    public $csvfile;

    #[Locked]
    public array $job = [];

    public function mount(array $job): void
    {
        $this->job = $job;
    }

    public function save(): mixed
    {
        if (!$this->csvfile) {
            throw ValidationException::withMessages(['csvfile' => __('Please, select a csv file to upload.')]);
        }

        $filename = Arr::join([
            $this->job['id'],
            now()->setTimezone(config('app.timezone'))->getTimestamp(),
            str()->slug($this->job['subject']),
        ], '-', '-') . '.csv';

        $this->csvfile->storeAs(path: 'csv_files', name: $filename);

        $items = new ItemsProcess($this->job, $filename);
        $items->process();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('The data was uploaded and processed successfully.'),
        ]);

        return $this->redirectRoute('jobs.show', ['id' => $this->job['id']]);
    }

    public function render(): View
    {
        return view('livewire.items-file-upload');
    }
}
