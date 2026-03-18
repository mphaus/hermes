<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductionAdministratorCreateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('ProductionAdministratorCreate', [
            'title' => 'Add Production Administrator',
            'description' => 'Double check the spelling of the name',
        ]);
    }
}
