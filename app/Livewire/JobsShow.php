<?php

namespace App\Livewire;

use App\Enums\JobStatus;
use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;

#[Lazy]
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

        $response = Http::current()->get("opportunities/{$this->id}?include[]=opportunity_items&include[]=participants");
        $appName = config('app.name');
        $notFoundText = __('Job not found');

        if ($response->failed()) {
            $this->js("document.title = '{$notFoundText}'");
            $this->js("document.querySelector('[data-element=\"app-heading\"]').textContent = '{$notFoundText}'");

            return [
                ...$defaultResponse,
                'error' => $this->errorMessage('An unexpected error occurred while fetching the details for this Job. Please refresh the page and try again.', $response->json()),
            ];
        }

        ['opportunity' => $opportunity] = $response->json();

        if (
            App::environment(['local', 'staging']) === false
            && $opportunity['status'] !== JobStatus::Active->value
        ) {
            $this->js("document.title = '{$notFoundText}'");
            $this->js("document.querySelector('[data-element=\"app-heading\"]').textContent = '{$notFoundText}'");

            return [
                ...$defaultResponse,
                'error' => $this->errorMessage('The requested Job could not be loaded. Please try a different Job.'),
            ];
        }

        $this->js("document.title = '{$appName} - {$opportunity['subject']}'");
        $this->js("document.querySelector('[data-element=\"app-heading\"]').textContent = '{$opportunity['subject']}'");

        return [
            ...$defaultResponse,
            'opportunity' => $opportunity,
        ];
    }

    public function placeholder(): View
    {
        return view('job-skeleton');
    }

    public function render(): View
    {
        return view('livewire.jobs-show');
    }
}
