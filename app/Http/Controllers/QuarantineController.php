<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuarantineRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuarantineController extends Controller
{
    public function store(StoreQuarantineRequest $request): JsonResponse
    {
        $request->validated();
        $quarantine = $request->store();

        session()->flash('quarantine', $quarantine);

        return response()->json([
            'redirect_to' => route('quarantine-intake-success.index'),
        ]);
    }
}
