<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipmentImportShowController extends Controller
{
    private const DATA = [
        'error' => '',
        'opportunity' => [],
    ];

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('EquipmentImportShow', [
            'title' => 'Equipment Import > Import',
            'opportunity_data' => Inertia::defer(fn() => $this->opportunityData($request->route('opportunity_id'))),
        ]);
    }

    private function opportunityData($opportunity_id)
    {
        $response = CurrentRMS::fetch(uri: "opportunities/{$opportunity_id}");

        if ($response->hasErrors()) {
            return [
                ...self::DATA,
                'error' => "An unexpected error occurred while fetching the Opportunity details. Please refresh the page and try again. {$response->getErrorString()}",
            ];
        }

        [
            'opportunity' => $opportunity,
        ] = $response->getData();

        return [
            ...self::DATA,
            'opportunity' => $opportunity ?? [],
        ];
    }
}
