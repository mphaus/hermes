<?php

namespace App\Http\Controllers;

use App\Traits\WithHttpCurrentError;
use Illuminate\Http\JsonResponse;
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
}
