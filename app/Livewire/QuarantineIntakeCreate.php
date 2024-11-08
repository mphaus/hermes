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

    public function save(): void
    {
        if (!usercan('access-quarantine-intake')) {
            abort(403);
        }

        $this->form->store();
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
