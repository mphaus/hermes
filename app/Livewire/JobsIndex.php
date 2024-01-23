<?php

namespace App\Livewire;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class JobsIndex extends Component
{
    use WithHttpCurrentError;
    use WithPagination;

    #[Computed]
    public function jobs()
    {
        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 2,
                'filtermode' => 'with_active_status',
            ])
            ->get('opportunities');

        if ($response->failed()) {
            return $this->errorMessage(__('An unexpected error occurred while fetching the Jobs list. Please refresh the page and try again.'), $response);
        }

        [
            'opportunities' => $opportunities,
            'meta' => $meta,
        ] = $response->json();

        return new LengthAwarePaginator(
            items: $opportunities,
            total: $meta['total_row_count'],
            perPage: $meta['per_page'],
            currentPage: $meta['page']
        );
    }

    public function render(): View
    {
        return view('livewire.jobs-index');
    }
}
