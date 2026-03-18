<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use Inertia\Inertia;

class ProductionAdministratorIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return Inertia::render('ProductionAdministratorIndex', [
            'title' => 'Production Administrators',
            'production_administrators_data' => Inertia::defer(fn() => $this->fetchProductionAdministrators())->once(),
        ]);
    }

    private function fetchProductionAdministrators()
    {
        $production_administrators = [
            'data' => [],
            'error' => '',
        ];
        $production_administrators_list_id = config('app.mph.production_administrator_list_id');
        $response = CurrentRMS::fetch(uri: "list_names/{$production_administrators_list_id}");

        if ($response->hasErrors()) {
            return [
                ...$production_administrators,
                'error' => "An unexpected error occurred while fetching the Production Administrators list. Please refresh the page and try again: {$response->getErrorString()}",
            ];
        }

        $not_yet_assigned_id = config('app.mph.production_administrator_not_yet_assigned_id');

        return [
            ...$production_administrators,
            'data' => collect(array_values(array_filter($response->getData()['list_name']['list_values'], fn($value) => $value['id'] !== intval($not_yet_assigned_id)))) ?? collect([]),
        ];
    }
}
