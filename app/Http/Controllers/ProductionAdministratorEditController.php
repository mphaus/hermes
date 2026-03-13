<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductionAdministratorEditController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $id = $request->route('id');

        if ($id == config('app.mph.production_administrator_not_yet_assigned_id')) {
            abort(404);
        }

        return Inertia::render('ProductionAdministratorEdit', [
            'title' => 'Edit Production Administrator',
            'description' => 'Double check the spelling of the name',
            'production_administrator' => Inertia::defer(fn() => $this->fetchProductionAdministrator(intval($id)))->once(),
        ]);
    }

    private function fetchProductionAdministrator(int $id)
    {
        $production_administrator = [
            'data' => null,
            'error' => '',
        ];

        $production_administrators_list_id = config('app.mph.production_administrator_list_id');
        $response = CurrentRMS::fetch(uri: "list_names/{$production_administrators_list_id}");

        if ($response->hasErrors()) {
            return [
                ...$production_administrator,
                'error' => "An unexpected error occurred while fetching the Production Administrator data: {$response->getErrorString()}",
            ];
        }

        ['list_name' => ['list_values' => $list_values]] = $response->getData();

        $filter = array_values(array_filter($list_values, fn($value) => $value['id'] === $id));
        $production_administrator_data = $filter ? $filter[0] : [];

        if (empty($production_administrator_data)) {
            return [
                ...$production_administrator,
                'error' => 'The requested Production Administrator could not be found.',
            ];
        }

        ['name' => $name] = $production_administrator_data;

        /**
         * @var string $name
         */

        $name = explode(' ', $name);
        $first_name = $name[0] ?? '';
        $last_name = $name[1] ?? '';

        return [
            ...$production_administrator,
            'data' => [
                'id' => $id,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ],
        ];
    }
}
