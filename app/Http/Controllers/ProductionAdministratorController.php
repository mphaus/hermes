<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionAdministratorRequest;
use App\Traits\WithHttpCurrentError;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductionAdministratorController extends Controller
{
    use WithHttpCurrentError;

    public function index(): JsonResponse
    {
        $production_administrators_list_id = config('app.mph.production_administrator_list_id');

        $response = Http::current()->get("list_names/{$production_administrators_list_id}");

        if ($response->failed()) {
            return response()->json([
                'error_message' => $this->errorMessage(__('An unexpected error occurred while fetching the Production Administrators list. Please refresh the page and try again.'), $response->json()),
            ], 400);
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        return response()->json([
            'production_administrators' => collect(array_values(array_filter($list_values, fn($value) => $value['id'] !== intval(config('app.mph.production_administrator_not_yet_assigned_id'))))),
        ]);
    }

    public function store(ProductionAdministratorRequest $request): JsonResponse
    {
        $request->validated();
        $request->store();

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('Production Administrator created successfully.'),
        ]);

        return response()->json([
            'redirect_to' => route('production-administrators.index.view'),
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        if ($id === intval(config('app.mph.production_administrator_not_yet_assigned_id'))) {
            return response()->json([
                'error_message' => __('The requested resource could not be found.'),
            ], 404);
        }

        $production_administrators_list_id = config('app.mph.production_administrator_list_id');

        $response = Http::current()->get("list_names/{$production_administrators_list_id}");

        if ($response->failed()) {
            return response()->json([
                'error_message' => $this->errorMessage(__('An unexpected error occurred while fetching the data for the Production Administrator to edit. Please refresh the page and try again.'), $response->json()),
            ], 400);
        }

        ['list_name' => ['list_values' => $list_values]] = $response->json();

        $filter = array_values(array_filter($list_values, fn($value) => $value['id'] === $id));

        $production_administrator = $filter ? $filter[0] : [];

        if (empty($production_administrator)) {
            return response()->json([
                'error_message' => __('The requested resource could not be found.'),
            ], 404);
        }

        ['name' => $name] = $production_administrator;

        /**
         * @var string $name
         */

        $name = explode(' ', $name);
        $first_name = $name[0] ?? '';
        $last_name = $name[1] ?? '';

        return response()->json([
            'production_administrator' => [
                'id' => $id,
                'first_name' => $first_name,
                'last_name' => $last_name,
            ],
        ]);
    }

    public function update(ProductionAdministratorRequest $request, int $id): JsonResponse
    {
        $request->validated();
        $request->store($id);

        session()->flash('alert', [
            'type' => 'success',
            'message' => __('Production Administrator updated successfully.'),
        ]);

        return response()->json([
            'redirect_to' => route('production-administrators.index.view'),
        ]);
    }
}
