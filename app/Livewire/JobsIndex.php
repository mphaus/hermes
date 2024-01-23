<?php

namespace App\Livewire;

use App\Traits\WithHttpCurrentError;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class JobsIndex extends Component
{
    private $page;

    use WithHttpCurrentError;
    use WithPagination;

    public function boot(Request $request)
    {
        $this->page = $request->query('page', 1);
    }

    #[Computed]
    public function jobs()
    {
        $response = Http::current()
            ->withQueryParameters([
                'page' => $this->page,
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

        return (new LengthAwarePaginator(
            items: $opportunities,
            total: $meta['total_row_count'],
            perPage: $meta['per_page']
        ))->withPath('/jobs');
    }

    public function render(): View
    {
        return view('livewire.jobs-index');
    }
}
