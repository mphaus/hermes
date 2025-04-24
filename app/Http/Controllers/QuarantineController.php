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

        return response()->json();
    }
}
