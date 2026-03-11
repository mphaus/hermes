<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use App\Http\Requests\StoreTechnicalSupervisorRequest;
use Inertia\Inertia;

class TechnicalSupervisorStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreTechnicalSupervisorRequest $request)
    {
        $validated = $request->validated();
        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');
        $response = CurrentRMS::fetch(uri: "list_names/{$technical_supervisors_list_id}");

        if ($response->hasErrors()) {
            return to_route('technical-supervisors.create')->withErrors([
                'message' => "An error occurred while attempting to save the data. Please refresh the page and try again. {$response->getErrorString()}",
            ]);
        }

        ['list_name' => ['list_values' => $list_values]] = $response->getData();
        ['first_name' => $first_name, 'last_name' => $last_name] = $validated;

        $data = [
            ...$list_values,
            [
                'list_name_id' => intval($technical_supervisors_list_id),
                'name' => "{$first_name} {$last_name}",
            ],
        ];

        $response = CurrentRMS::update(uri: "list_names/{$technical_supervisors_list_id}", data: [
            'list_name' => [
                'list_values' => $data,
            ],
        ]);

        if ($response->hasErrors()) {
            return to_route('technical-supervisors.create')->withErrors([
                'message' => "An error occurred while attempting to save the data. Please refresh the page and try again. {$response->getErrorString()}",
            ]);
        }

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Technical Supervisor created successfully.',
        ]);

        return to_route('technical-supervisors.index');
    }
}
