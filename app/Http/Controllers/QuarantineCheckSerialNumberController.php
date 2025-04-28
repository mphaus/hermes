<?php

namespace App\Http\Controllers;

use App\Rules\UniqueSerialNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuarantineCheckSerialNumberController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'serial_number' => [
                'required',
                'max:256',
                'regex:/^[a-zA-Z0-9\/.\-\s]+$/',
                new UniqueSerialNumber('serial-number-exists'),
            ],
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
