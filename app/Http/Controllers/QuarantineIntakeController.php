<?php

namespace App\Http\Controllers;

use App\Http\Requests\QIReportMistakeFormRequest;
use Illuminate\Http\Request;

class QuarantineIntakeController extends Controller
{
    public function success(Request $request)
    {
        $quarantine = $request->session()->get('quarantine', []);

        if (empty($quarantine)) {
            return redirect()->route('quarantine-intake.create');
        }

        return view('quarantine-intake-success', compact('quarantine'));
    }

    public function reportMistake(QIReportMistakeFormRequest $request)
    {
        $validated = $request->validated();

        return response()->json([
            'type' => 'success',
            'request' => $validated,
        ]);
    }
}
