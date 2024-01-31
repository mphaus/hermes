<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class OpportunityItemsCreate extends Component
{
    use WithFileUploads;

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

        $this->csvfile->storeAs(path: 'csv_files', name: $filename);

        $data = [];
        $header = null;
        $requiredHeadings = ['id', 'quantity', 'group_name'];

        if (($handle = fopen(base_path() . '/storage/app/csv_files/' . $filename, "r")) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($header === null) {
                    $header = $row;

                    // VALIDATE HEADINGS
                    $diff = array_diff($requiredHeadings, $header);

                    if (count($diff) > 0) {
                        $missingHeaders = Arr::join($diff, ', ', ' and ');
                        throw ValidationException::withMessages(['csvfile' => __('The uploaded csv file does not contain the valid headers required to identify the data. Missing headers: :missing_headers.', ['missing_headers' => $missingHeaders])]);
                    }

                    continue;
                }

                $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        // EXTRACT EXISTING GROUPS
        $existingGroups = array_map(fn ($group) => ['id' => $group['id'], 'name' => $group['name']], array_filter($this->job['opportunity_items'], fn ($item) => $item['opportunity_item_type_name'] === 'Group'));

        dd($existingGroups);
        dd($data);
    }

    public function render(): View
    {
        return view('livewire.opportunity-items-create');
    }
}
