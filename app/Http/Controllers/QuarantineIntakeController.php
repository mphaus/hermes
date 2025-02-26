<?php

namespace App\Http\Controllers;

use App\Http\Requests\QIReportMistakeFormRequest;
use App\Mail\QIReportMistakeCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        Mail::to('garion@mphaus.com')->send(new QIReportMistakeCreated($validated, Auth::user()));

        return response()->json([
            'message' => __('Your message has been sent successfully.'),
        ]);
    }
}
