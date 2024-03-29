<?php

namespace App\Livewire;

use App\Traits\WithActionType;
use App\Traits\WithHttpCurrentError;
use App\Traits\WithMember;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class ActionStreamIndex extends Component
{
    use WithActionType;
    use WithMember;
    use WithPagination;
    use WithHttpCurrentError;

    #[Computed]
    public function actions(): array
    {
        $defaultResponse = [
            'error' => '',
            'log' => collect([]),
        ];

        $queryParams = [
            'page' => $this->getPage(),
            'per_page' => 20,
            'include[]' => 'all',
            'q[member_id_in]' => array_map(fn ($member) => $member['id'], $this->getMembers()),
            'q[action_type_in]' => array_map(fn ($type) => $type['key'], $this->getActionTypes()),
            'q[updated_at_gteq]' => now()->timezone(config('app.timezone'))->subDays(3)->format('Y-m-d'), // LAST THREE DAYS
            'q[updated_at_lteq_date]' => now()->timezone(config('app.timezone'))->format('Y-m-d'), // TODAY
        ];

        $queryParams = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query($queryParams)));

        $response = Http::current()->get("actions?{$queryParams}");

        if ($response->failed()) {
            dd('Handle error');
        }

        [
            'actions' => $log,
            'meta' => $meta,
        ] = $response->json();

        if (empty($log)) {
            return $defaultResponse;
        }

        return [
            ...$defaultResponse,
            'log' => (new LengthAwarePaginator(
                items: $log,
                total: $meta['total_row_count'],
                perPage: $meta['per_page'],
            ))->withPath('/action-stream'),
        ];
    }

    public function placeholder(): View
    {
        return view('action-stream-skeleton');
    }

    public function render(): View
    {
        return view('livewire.action-stream-index');
    }
}
