<?php

namespace App\Livewire;

use App\Enums\JobStatus;
use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CreateDiscussionsOpportunity extends Component
{
    use WithHttpCurrentError;

    #[Computed]
    public function jobs(): array
    {
        $defaultResponse = [
            'error' => '',
            'opportunities' => [],
        ];

        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 25,
                'filtermode' => 'orders',
                'q[status_eq]' => JobStatus::Open->value,
                'q[id_not_eq]' => config('app.mph.test_opportunity_id'),
            ])
            ->get('opportunities');

        if ($response->failed()) {
            return [
                ...$defaultResponse,
                'error' => $this->errorMessage(__('An unexpected error occurred while fetching Opportunities. Please refresh the page and try again.'), $response->json()),
            ];
        }

        ['opportunities' => $opportunities] = $response->json();

        if (empty($opportunities)) {
            return $defaultResponse;
        }

        return [
            ...$defaultResponse,
            'opportunities' => $opportunities,
        ];
    }

    public function placeholder(): View
    {
        return view('create-discussions-skeleton');
    }

    public function render(): View
    {
        return view('livewire.create-discussions-opportunity');
    }
}
