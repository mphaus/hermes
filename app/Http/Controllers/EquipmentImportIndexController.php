<?php

namespace App\Http\Controllers;

use App\Enums\JobStatus;
use App\Facades\CurrentRMS;
use Illuminate\Http\Request;
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
            'opportunities_data' => Inertia::defer(fn() => $this->opportunitiesData())->once(),
        ]);
    }

    private function opportunitiesData()
    {
        $response = CurrentRMS::fetch(uri: 'opportunities', params: [
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

        return [
            ...self::DATA,
            'data' => $response->getData()['opportunities'] ?? [],
        ];
    }
}
