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

        return Inertia::render(component: 'QuarantineSuccess', props: [
            'quarantine' => $quarantine,
        ]);
    }
}
