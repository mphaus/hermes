<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Inertia\Inertia;
use Symfony\Component\Console\Color;

class EquipmentImportShowController extends Controller
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
        return Inertia::render('EquipmentImportShow', [
            'title' => 'Equipment Import > Import',
            'opportunity_data' => Inertia::defer(fn() => $this->opportunityData($request->route('opportunity_id'))),
            'opportunities_url' => config('app.mph.opportunities_url'),
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


        $opportunity = empty($opportunity) ? [] : [
            ...$opportunity,
            'starts_at_formatted' => $opportunity['starts_at'] ? Carbon::parse($opportunity['starts_at'])->timezone(config('app.timezone'))->format('d-M-Y') : null,
            'ends_at_formatted' => $opportunity['ends_at'] ? Carbon::parse($opportunity['ends_at'])->timezone(config('app.timezone'))->format('d-M-Y') : null,
            'charge_total_formatted' => $opportunity['charge_total'] ? Number::currency($opportunity['charge_total']) : null,
        ];

        return [
            ...self::DATA,
            'data' => $opportunity,
        ];
    }
}
