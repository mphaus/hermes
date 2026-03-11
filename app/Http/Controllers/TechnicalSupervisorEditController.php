<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TechnicalSupervisorEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $id = $request->route('id');

        if ($id === config('app.mph.technical_supervisor_not_yet_assigned_id')) {
            abort(404);
        }

        return Inertia::render('TechnicalSupervisorEdit', [
            'title' => 'Edit Technical Supervisor',
            'description' => 'Double check the spelling of the name',
            'technical_supervisor' => Inertia::defer(fn() => $this->fetchTechnicalSupervisor(intval($id)))->once(),
        ]);
    }

    private function fetchTechnicalSupervisor(int $id)
    {
        $technical_supervisor = [
            'data' => null,
            'error' => '',
        ];

        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');
        $response = CurrentRMS::fetch(uri: "list_names/{$technical_supervisors_list_id}", new_api: true);

        if ($response->hasErrors()) {
            return [
                ...$technical_supervisor,
                'error' => "An unexpected error occurred while fetching the Technical Supervisor data: {$response->getErrorString()}",
            ];
        }

        ['list_name' => ['list_values' => $list_values]] = $response->getData();

        $filter = array_values(array_filter($list_values, fn($value) => $value['id'] === $id));
        $technical_supervisor_data = $filter ? $filter[0] : [];

        if (empty($technical_supervisor_data)) {
            return [
                ...$technical_supervisor,
                'error' => 'The requested Technical Supervisor could not be found.',
            ];
        }

        ['name' => $name] = $technical_supervisor_data;

        /**
         * @var string $name
         */

        $name = explode(' ', $name);
        $first_name = $name[0] ?? '';
        $last_name = $name[1] ?? '';

        return [
            $technical_supervisor,
            'data' => [
                'id' => $id,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ],
        ];
    }
}
