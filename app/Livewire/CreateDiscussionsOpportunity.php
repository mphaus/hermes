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

        $queryParams = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query([
            'per_page' => 25,
            // 'filtermode' => 'orders',
            'q' => [
                'status_in' => [
                    JobStatus::Open->value,
                    JobStatus::Reserved->value,
                ]
            ],
            // 'q[id_not_eq]' => config('app.mph.test_opportunity_id'),
        ])));

        $response = Http::current()
            // ->withQueryParameters($queryParams)
            ->get("opportunities?{$queryParams}");

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
