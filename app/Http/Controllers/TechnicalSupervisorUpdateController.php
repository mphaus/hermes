<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTechnicalSupervisorRequest;
use App\Facades\CurrentRMS;
use Inertia\Inertia;

class TechnicalSupervisorUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreTechnicalSupervisorRequest $request)
    {
        $validated = $request->validated();
        $id = $request->route('id');
        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');
        $response = CurrentRMS::fetch(uri: "list_names/{$technical_supervisors_list_id}", new_api: true);

        if ($response->hasErrors()) {
            return to_route('technical-supervisors.edit', $id)->withErrors([
                'message' => "An error occurred while attempting to save the data. Please refresh the page and try again. {$response->getErrorString()}",
            ]);
        }

        ['list_name' => ['list_values' => $list_values]] = $response->getData();
        ['first_name' => $first_name, 'last_name' => $last_name] = $validated;

        $column = array_column($list_values, 'id');
        $i = array_search($id, $column);
        $list_values[$i]['name'] = "{$first_name} {$last_name}";
        $data = [...$list_values];

        $response = CurrentRMS::update(uri: "list_names/{$technical_supervisors_list_id}", data: [
            'list_name' => [
                'list_values' => $data,
            ],
        ]);

        if ($response->hasErrors()) {
            return to_route('technical-supervisors.edit', $id)->withErrors([
                'message' => "An error occurred while attempting to save the data. Please refresh the page and try again. {$response->getErrorString()}",
            ]);
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Technical Supervisor updated successfully.',
        ]);

        return to_route('technical-supervisors.index');
    }
}
