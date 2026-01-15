<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class QuarantineSuccessController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $quarantine = $request->session()->get('quarantine', []);

        if (empty($quarantine)) {
            return to_route('quarantine.create');
        }

        return Inertia::render(component: 'QuarantineSuccess', props: [
            'title' => 'Quarantine Intake Success',
            'description' => 'Success!',
            'quarantine' => $quarantine,
        ]);
    }
}
