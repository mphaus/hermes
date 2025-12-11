<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuarantineReportMistakeFormRequest;
use App\Http\Requests\StoreQuarantineRequest;
use App\Mail\QuarantineReportMistakeCreated;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class QuarantineController extends Controller
{
    public function store(StoreQuarantineRequest $request): JsonResponse
    {
        $request->validated();
        $quarantine = $request->store();

        session()->flash('quarantine', $quarantine);

        return response()->json([
            'redirect_to' => route('quarantine.success.index'),
        ]);
    }

    public function success(Request $request): RedirectResponse|View
    {
        $quarantine = $request->session()->get('quarantine', []);

        if (empty($quarantine)) {
            return redirect()->route('quarantine.create.view');
        }

        return view('quarantine.success', compact('quarantine'));
    }

    public function storeReport(QuarantineReportMistakeFormRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Mail::to(config('app.mph.notification_mail_address'))->send(new QuarantineReportMistakeCreated($validated, Auth::user()));

        return response()->json([
            'message' => __('Your message has been sent successfully.'),
        ]);
    }
}
