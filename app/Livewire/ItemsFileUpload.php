<?php

namespace App\Livewire;

use App\Traits\WithItemsProcess;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class ItemsFileUpload extends Component
{
    use WithFileUploads;
    use WithItemsProcess;

    #[Validate('file', message: 'This field must be a file.')]
    #[Validate('max:1024', message: 'The :attribute field must not be greater than :max kilobytes.')]
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
        $filename = Arr::join([
            $this->job['id'],
            now()->setTimezone(config('app.timezone'))->getTimestamp(),
            str()->slug($this->job['subject']),
        ], '-', '-') . '.csv';

        $this->csvfile->storeAs(path: $this->path, name: $filename);
        $this->processItems($this->job, $filename);

        dd('Success');
    }

    public function render(): View
    {
        return view('livewire.items-file-upload');
    }
}
