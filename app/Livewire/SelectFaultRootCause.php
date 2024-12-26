<?php

namespace App\Livewire;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SelectFaultRootCause extends Component
{
    use WithHttpCurrentError;

    public bool $multiple = false;

    #[Computed]
    public function data(): array
    {
        $default_response = [
            'error' => '',
            'fault_root_causes' => collect([]),
        ];

        $fault_root_cause_list_id = config('app.mph.fault_root_cause_list_id');

        $response = Http::current()->get("list_names/{$fault_root_cause_list_id}");

        if ($response->failed()) {
            return [
                ...$default_response,
                'error' => $this->errorMessage(__('An unexpected error occurred while fetching the Fault Root causes list. Please refresh the page and try again.'), $response->json()),
            ];
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        return [
            ...$default_response,
            'fault_root_causes' => collect(array_filter($list_values, fn($fault_root_cause) => $fault_root_cause['name'] !== '-- Select one --' || $fault_root_cause['name'] !== 'Not yet assigned')),
        ];
    }

    public function placeholder(): View
    {
        return view('select-fault-root-cause-skeleton');
    }

    public function render(): View
    {
        return view('livewire.select-fault-root-cause');
    }
}
