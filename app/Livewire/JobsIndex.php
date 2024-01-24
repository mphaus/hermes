<?php

namespace App\Livewire;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;

class JobsIndex extends Component
{
    use WithHttpCurrentError;

    #[Computed()]
    public function jobs(): array
    {
        $defaultResponse = [
            'error' => '',
            'opportunities' => collect([]),
        ];

        $response = Http::current()
            ->withQueryParameters([
                'page' => request()->query('page', 1),
                'per_page' => 25,
                'filtermode' => 'with_active_status',
            ])
            ->get('opportunities');

        if ($response->failed()) {
            return [
                ...$defaultResponse,
                'error' => $this->errorMessage(__('An unexpected error occurred while fetching the Jobs list. Please refresh the page and try again.'), $response),
            ];
        }

        [
            'opportunities' => $opportunities,
            'meta' => $meta,
        ] = $response->json();

        if (empty($opportunities)) {
            return $defaultResponse;
        }

        return [
            ...$defaultResponse,
            'opportunities' => (new LengthAwarePaginator(
                items: $opportunities,
                total: $meta['total_row_count'],
                perPage: $meta['per_page']
            ))->withPath('/jobs'),
        ];
    }

    public function render(): View
    {
        return view('livewire.jobs-index');
    }
}
