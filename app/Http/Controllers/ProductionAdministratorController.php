<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionAdministratorRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductionAdministratorController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        if ($request->isXmlHttpRequest()) {
            sleep(5);
            return response()->json([]);
        }

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
