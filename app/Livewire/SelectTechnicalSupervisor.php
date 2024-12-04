<?php

namespace App\Livewire;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SelectTechnicalSupervisor extends Component
{
    use WithHttpCurrentError;

    public bool $multiple = false;

    #[Computed]
    public function data(): array
    {
        $default_response = [
            'error' => '',
            'technical_supervisors' => collect([]),
        ];

        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');

        $response = Http::current()->get("list_names/{$technical_supervisors_list_id}");

        if ($response->failed()) {
            return [
                ...$default_response,
                'error' => $this->errorMessage(__('An unexpected error occurred while fetching the Technical Supervisors list. Please refresh the page and try again.'), $response->json()),
            ];
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        return [
            ...$default_response,
            'technical_supervisors' => collect(array_filter($list_values, fn($technical_supervisor) => $technical_supervisor['name'] !== 'Not yet assigned')),
        ];
    }

    public function placeholder(): View
    {
        return view('select-technical-supervisor-skeleton');
    }

    public function render(): View
    {
        return view('livewire.select-technical-supervisor');
    }
}
