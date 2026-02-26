<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuarantineReportMistakeRequest;
use App\Mail\QuarantineReportMistakeCreated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class QuarantineReportMistakeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(QuarantineReportMistakeRequest $request)
    {
        $validated = $request->validated();

        Mail::to(config('app.mph.service_manager_mail_address'))->send(new QuarantineReportMistakeCreated($validated, Auth::user()));

        $request->session()->forget('quarantine');

        Inertia::flash('toast', [
            'type' => 'success',
            'message' => 'Your report has been sent successfully to the Service Manager.',
        ]);

        return to_route('quarantine.create');
    }
}
