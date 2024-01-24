<?php

namespace App\Livewire\Pages;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class JobsShow extends Component
{
    use WithHttpCurrentError;

    protected int $id;

    public function mount(int $id): void
    {
        $this->id = $id;
    }

    #[Computed]
    public function job(): array
    {
        $defaultResponse = [
            'error' => '',
            'opportunity' => [],
        ];

        $response = Http::current()->get("opportunities/{$this->id}");

        if ($response->failed()) {
            return [
                ...$defaultResponse,
                'error' => $this->errorMessage('An unexpected error occurred while fetching the details for this Job. Please refresh the page and try again.', $response),
            ];
        }

        ['opportunity' => $opportunity] = $response->json();

        return [
            ...$defaultResponse,
            'opportunity' => $opportunity,
        ];
    }

    public function render(): View
    {
        return view('livewire.pages.jobs-show');
    }
}
