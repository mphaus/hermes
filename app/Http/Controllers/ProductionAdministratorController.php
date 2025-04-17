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
            'production_administrators' => collect(array_values(array_filter($list_values, fn($value) => $value['name'] !== 'Not yet assigned'))),
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
}
