<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TechnicalSupervisorCreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('TechnicalSupervisorCreate', [
            'title' => 'Add Technical Supervisor',
            'description' => 'Double check the spelling of the name',
        ]);
    }
}
