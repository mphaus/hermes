<?php

namespace App\Livewire;

use App\Traits\WithOpportunityItemsUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class OpportunityItemsCreate extends Component
{
    use WithFileUploads;
    use WithOpportunityItemsUpload;

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

    public function save(): void
    {
        $filename = Arr::join([
            $this->job['id'],
            now()->setTimezone(config('app.timezone'))->getTimestamp(),
            str()->slug($this->job['subject']),
        ], '-', '-') . '.csv';

        $this->csvfile->storeAs(path: $this->path, name: $filename);

        $data = [];
        $header = null;
        if (($handle = fopen(base_path() . '/storage/app/' . $this->path . '/' . $filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($header === null) {
                    $header = $row;
                    continue;
                }

                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        dd($data);
    }

    public function render(): View
    {
        return view('livewire.opportunity-items-create');
    }
}
