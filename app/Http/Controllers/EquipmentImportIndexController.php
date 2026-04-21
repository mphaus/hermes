<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Facades\CurrentRMS;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class EquipmentImportIndexController extends Controller
{
    private const DATA = [
        'error' => '',
        'data' => [],
    ];

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('EquipmentImportIndex', [
            'title' => 'Equipment Import',
            'description' => 'Opportunities in CurrentRMS with the state of <strong>Order</strong> and <strong>Open</strong>.',
            'opportunities_data' => Inertia::defer(fn() => $this->opportunitiesData()),
        ]);
    }

    private function opportunitiesData()
    {
        $page = request()->query('page', 1);

        $response = CurrentRMS::fetch(uri: 'opportunities', params: [
            'page' => $page,
            'per_page' => 25,
            'filtermode' => 'orders',
            'q[status_eq]' => JobStatus::Open->value,
        ]);

        if ($response->hasErrors()) {
            return [
                ...self::DATA,
                'error' => "An unexpected error occurred while fetching the Opportunities list. Please refresh the page and try again. {$response->getErrorString()}",
            ];
        }

        [
            'opportunities' => $opportunities,
            'meta' => $meta,
        ] = $response->getData();

        [
            'total_row_count' => $total_row_count,
            'per_page' => $per_page,
        ] = $meta;

        $paginator = new LengthAwarePaginator(
            items: collect($opportunities ?? [])->map(fn($opportunity) => [
                ...$opportunity,
                'starts_at_formatted' => $opportunity['starts_at'] ? Carbon::parse($opportunity['starts_at'])->timezone(config('app.timezone'))->format('d-M-Y') : null,
                'ends_at_formatted' => $opportunity['ends_at'] ? Carbon::parse($opportunity['ends_at'])->timezone(config('app.timezone'))->format('d-M-Y') : null,
            ])->all(),
            total: $total_row_count,
            perPage: $per_page,
            currentPage: $page,
        );

        $paginator->withPath('/inertia/equipment-import');
        $pagination_data = $paginator->toArray();

        return [
            'error' => '',
            'data' => $pagination_data['data'],
            'current_page' => $pagination_data['current_page'],
            'per_page' => $pagination_data['per_page'],
            'total' => $pagination_data['total'],
            'links' => $pagination_data['links'],
        ];
    }
}
