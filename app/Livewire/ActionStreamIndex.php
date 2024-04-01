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
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Lazy]
class ActionStreamIndex extends Component
{
    use WithActionType;
    use WithMember;
    use WithPagination;
    use WithHttpCurrentError;

    #[Url(as: 'members')]
    public array $memberIds = [];

    #[Url(as: 'action-types')]
    public array $actionTypes = [];

    #[Url(as: 'date-range')]
    public array $dateRange = [];

    #[Url(as: 'time-period')]
    public string $timePeriod = '';

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
            'q[updated_at_gteq]' => now()->timezone('UTC')->subDays(3)->format('Y-m-d'), // LAST THREE DAYS
            'q[updated_at_lteq_date]' => now()->timezone('UTC')->format('Y-m-d'), // TODAY
        ];

        if ($this->memberIds) {
            $queryParams['q[member_id_in]'] = array_map(fn ($member) => $member, $this->memberIds);
        }

        if ($this->actionTypes) {
            $queryParams['q[action_type_in]'] = array_map(fn ($type) => $type, $this->actionTypes);
        }

        if ($this->dateRange) {
            $queryParams['q[updated_at_gteq]'] = now()->createFromFormat('Y-m-d', $this->dateRange[0], 'UTC')->format('Y-m-d');
            $queryParams['q[updated_at_lteq_date]'] = now()->createFromFormat('Y-m-d', $this->dateRange[1], 'UTC')->format('Y-m-d');
        }

        if ($this->timePeriod) {
            switch ($this->timePeriod) {
                case 'this-week':
                    $queryParams['q[updated_at_gteq]'] = now()->timezone('UTC')->startOfWeek()->format('Y-m-d');
                    $queryParams['q[updated_at_lteq_date]'] = now()->timezone('UTC')->endOfWeek()->format('Y-m-d');
                    break;
                case 'this-month':
                    $queryParams['q[updated_at_gteq]'] = now()->timezone('UTC')->startOfMonth()->format('Y-m-d');
                    $queryParams['q[updated_at_lteq_date]'] = now()->timezone('UTC')->endOfMonth()->format('Y-m-d');
                    break;
                default:
                    break;
            }
        }

        $queryParams = preg_replace('/\[\d+\]/', '[]', urldecode(http_build_query($queryParams)));

        $response = Http::current()->get("actions?{$queryParams}");

        if ($response->failed()) {
            return [
                ...$defaultResponse,
                'error' => $this->errorMessage(__('An unexpected error occurred while fetching the Actions list. Please refresh the page and try again.'), $response->json()),
            ];
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

    public function setFilters(array $memberIds = [], array $actionTypes = [], array $dateRange = [], string $timePeriod)
    {
        $this->memberIds = $memberIds;
        $this->actionTypes = $actionTypes;
        $this->dateRange = $timePeriod ? [] : $dateRange;
        $this->timePeriod = $timePeriod;
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
