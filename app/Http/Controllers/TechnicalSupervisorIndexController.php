<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use Inertia\Inertia;

class TechnicalSupervisorIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return Inertia::render('TechnicalSupervisorIndex', [
            'title' => 'Technical Supervisors',
            'description' => 'This lists MPH Technical Supervisors that can be associated with Opportunities in CurrentRMS (this is done during Pre-Production by the Crew and Logistics Assistant). In turn, this is used to assign Technical Supervisors to Quarantined items. Names can be edited later if necessary.',
            'technical_supervisors_data' => Inertia::defer(fn() => $this->fetchTechnicalSupervisors())->once(),
        ]);
    }

    private function fetchTechnicalSupervisors()
    {
        $technical_supervisors = [
            'data' => [],
            'error' => '',
        ];
        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');
        $response = CurrentRMS::fetch(uri: "list_names/{$technical_supervisors_list_id}", new_api: true);

        if ($response->hasErrors()) {
            return [
                ...$technical_supervisors,
                'error' => 'An unexpected error occurred while fetching the Technical Supervisors list. Please refresh the page and try again. ' . $response->getErrorString(),
            ];
        }

        $not_yet_assigned_id = config('app.mph.technical_supervisor_not_yet_assigned_id');

        return [
            ...$technical_supervisors,
            'data' => collect(array_values(array_filter($response->getData()['list_name']['list_values'], fn($value) => $value['id'] !== intval($not_yet_assigned_id)))) ?? collect([]),
        ];
    }
}
