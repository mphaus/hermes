<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechnicalSupervisorRequest;
use App\Traits\WithHttpCurrentError;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TechnicalSupervisorController extends Controller
{
    use WithHttpCurrentError;

    public function index(): JsonResponse
    {
        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');

        $response = Http::current()->get("list_names/{$technical_supervisors_list_id}");

        if ($response->failed()) {
            return response()->json([
                'error_message' => $this->errorMessage(__('An unexpected error occurred while fetching the Technical Supervisors list. Please refresh the page and try again.'), $response->json()),
            ], 400);
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        return response()->json([
            'technical_supervisors' => collect(array_values(array_filter($list_values, fn($value) => $value['id'] !== intval(config('app.mph.technical_supervisor_not_yet_assigned_id'))))),
        ]);

        return response()->json();
    }

    public function store(TechnicalSupervisorRequest $request): JsonResponse
    {
        $request->validated();
        $request->store();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('Technical Supervisor created successfully.'),
        ]);

        return response()->json([
            'redirect_to' => route('technical-supervisors.index.view'),
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        if ($id === intval(config('app.mph.technical_supervisor_not_yet_assigned_id'))) {
            return response()->json([
                'error_message' => __('The requested resource could not be found.'),
            ], 404);
        }

        $technical_supervisors_list_id = config('app.mph.technical_supervisor_list_id');

        $response = Http::current()->get("list_names/{$technical_supervisors_list_id}");

        if ($response->failed()) {
            return response()->json([
                'error_message' => $this->errorMessage(__('An unexpected error occurred while fetching the Technical Supervisors list. Please refresh the page and try again.'), $response->json()),
            ], 400);
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        $filter = array_values(array_filter($list_values, fn($value) => $value['id'] === $id));

        $technical_supervisor = $filter ? $filter[0] : [];

        if (empty($technical_supervisor)) {
            return response()->json([
                'error_message' => __('The requested resource could not be found.'),
            ], 404);
        }

        ['name' => $name] = $technical_supervisor;

        /**
         * @var string $name
         */

        $name = explode(' ', $name);
        $first_name = $name[0] ?? '';
        $last_name = $name[1] ?? '';

        return response()->json([
            'technical_supervisor' => [
                'id' => $id,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ],
        ]);
    }

    public function update(TechnicalSupervisorRequest $request, int $id): JsonResponse
    {
        $request->validated();
        $request->store($id);

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('Technical Supervisor updated successfully.'),
        ]);

        return response()->json([
            'redirect_to' => route('technical-supervisors.index.view'),
        ]);
    }
}
