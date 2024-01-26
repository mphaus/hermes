<?php

namespace App\Livewire\Pages;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class Jobs extends Component
{
    use WithPagination;
    use WithHttpCurrentError;

    public bool $beingPaginated = false;

    #[Computed]
    public function jobs(): array
    {
        $defaultResponse = [
            'error' => '',
            'opportunities' => collect([]),
        ];

        $response = Http::current()
            ->withQueryParameters([
                'page' => $this->getPage(),
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

    public function updatedPage()
    {
        $this->beingPaginated = false;
    }

    public function placeholder(): View
    {
        return view('jobs-skeleton');
    }

    public function render(): View
    {
        return view('livewire.pages.jobs');
    }
}
