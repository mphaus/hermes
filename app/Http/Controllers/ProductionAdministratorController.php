<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionAdministratorRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class ProductionAdministratorController extends Controller
{
    public function index(): View
    {
        return view('production-administrator.index');
    }

    public function create(): View
    {
        return view('production-administrator.create');
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
            'redirect_to' => route('production-administrators.index'),
        ]);
    }
}
