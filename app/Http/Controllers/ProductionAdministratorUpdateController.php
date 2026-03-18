<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use App\Http\Requests\StoreProductionAdministratorRequest;
use Inertia\Inertia;

class ProductionAdministratorUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreProductionAdministratorRequest $request)
    {
        $validated = $request->validated();
        $id = $request->route('id');
        $production_administrators_list_id = config('app.mph.production_administrator_list_id');
        $response = CurrentRMS::fetch(uri: "list_names/{$production_administrators_list_id}");

        if ($response->hasErrors()) {
            return to_route('production-administrators.edit', $id)->withErrors([
                'message' => "An error occurred while attempting to save the data. Please refresh the page and try again. {$response->getErrorString()}",
            ]);
        }

        ['list_name' => ['list_values' => $list_values]] = $response->getData();
        ['first_name' => $first_name, 'last_name' => $last_name] = $validated;

        $column = array_column($list_values, 'id');
        $i = array_search((int) $id, $column);
        $list_values[$i]['name'] = "{$first_name} {$last_name}";
        $data = [...$list_values];

        $response = CurrentRMS::update(uri: "list_names/{$production_administrators_list_id}", data: [
            'list_name' => [
                'list_values' => $data,
            ],
        ]);

        if ($response->hasErrors()) {
            return to_route('production-administrators.edit', $id)->withErrors([
                'message' => "An error occurred while attempting to save the data. Please refresh the page and try again. {$response->getErrorString()}",
            ]);
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => __('Production Administrator updated successfully.'),
        ]);

        return to_route('production-administrators.index');
    }
}
