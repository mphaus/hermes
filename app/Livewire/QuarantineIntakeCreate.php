<?php

namespace App\Livewire;

use App\Livewire\Forms\QuarantineIntakeForm;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
class QuarantineIntakeCreate extends Component
{
    public QuarantineIntakeForm $form;

    public array $alert = [];

    #[Computed]
    public function technicalSupervisors()
    {
        $technical_supervisor_list_id = config('app.mph.technical_supervisor_list_id');
        $response = Http::current()->get("list_names/{$technical_supervisor_list_id}");

        if ($response->failed()) {
            return [];
        }

        ['list_name' => $list_name] = $response->json();

        if (empty($list_name)) {
            return [];
        }

        ['list_values' => $list_values] = $list_name;

        return array_map(fn($list_value) => [
            'id' => $list_value['id'],
            'name' => $list_value['name'],
        ], $list_values);
    }

    public function save()
    {
        if (!usercan('access-quarantine-intake')) {
            abort(403);
        }

        $result = $this->form->store();

        if (!is_numeric($result)) {
            $this->alert = [
                'type' => 'error',
                'message' => __('Fail! ❌ The item was not added to CurrentRMS because ":error". This item still needs to be added. You may wish to copy the Fault description of ":fault_description" to save re-typing it.', ['error' => $result[0], 'fault_description' => $this->form->description]),
            ];

            return;
        }

        $this->form->clear();
        $this->alert = [
            'type' => 'success',
            'message' => __('Success! ✅ The item has been added to Quarantine (<a href=":url" target="_blank" rel="nofollow">in CurrentRMS</a>)', ['url' => "https://mphaustralia.current-rms.com/quarantines/{$result}"]),
        ];

        $this->dispatch('quarantine-intake-created');
    }

    public function placeholder(): View
    {
        return view('quarantine-intake-create-skeleton');
    }

    public function render(): View
    {
        return view('livewire.quarantine-intake-create');
    }
}
