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

    public function mount()
    {
        $this->form->starts_at = now()->format('Y-m-d');
    }

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

        ['type' => $type, 'errors' => $errors, 'data' => $quarantine] = $this->form->store();

        if ($type === 'error') {
            $this->alert = [
                'type' => 'error',
                'message' => __('<p>Fail! ❌ The Quarantine Item was not added to CurrentRMS because <span class="font-semibold">:error</span>. This item still needs to be added. It\'s fine to try again, but the same error may return.</p><p>See <a href=":url" target="_blank" rel="nofollow" title="Dealing with errors when adding items to Quarantine via Hermes section" class="font-semibold">Dealing with errors when adding items to Quarantine via Hermes section</a> in the Quarantine Intake Process for instructions on what to do next.</p>', ['error' => $errors[0], 'url' => 'https://mphaustralia.sharepoint.com/:w:/r/teams/MPHAdministration/Shared%20Documents/Process/01%20In%20development/Process_%20Repairs%20Quarantine%20intake.docx?d=wc450b4cdc2e84c758363390091b56915&csf=1&web=1&e=sFkHAk&nav=eyJoIjoiMzg4NTM5MDQifQ'])
            ];

            return;
        }

        session(['quarantine' => $quarantine]);
        // session()->flash('quarantine', $quarantine);
        return redirect()->route('quarantine-intake-success.index');
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
