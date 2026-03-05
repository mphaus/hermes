<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TechnicalSupervisorIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('TechnicalSupervisorIndex', [
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

        return [
            ...$technical_supervisors,
            'data' => $response->getData()['list_name']['list_values'] ?? [],
        ];
    }
}
