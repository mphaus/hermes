<?php

namespace App\Livewire;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TechnicalSupervisorsIndex extends Component
{
    use WithHttpCurrentError;

    #[Computed]
    public function technicalSupervisors(): array
    {
        $default_response = [
            'error' => '',
            'people' => collect([]),
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
            'people' => collect(array_filter($list_values, fn($ts) => $ts['name'] !== '-- Select one --')),
        ];
    }

    public function render(): View
    {
        return view('livewire.technical-supervisors-index');
    }
}
