<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuarantineIntakeController extends Controller
{
    public function success(Request $request)
    {
        $quarantine = $request->session()->get('quarantine', []);

        // if (empty($quarantine)) {
        //     return redirect()->route('quarantine-intake.create');
        // }

        return view('quarantine-intake-success', compact('quarantine'));
    }

    public function reportMistake(Request $request)
    {
        return response()->json(data: [
            'type' => 'error',
            'request' => $request->all()
        ], status: 400);
    }
}
