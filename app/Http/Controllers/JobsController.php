<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JJSoftwareLtd\CurrentGateway\Facades\CurrentGateway;

class JobsController extends Controller
{
    public function index()
    {
        $req = CurrentGateway::get('opportunities', [
            'per_page' => 25,
            'filtermode' => 'with_active_status',
        ]);

        $opportunities = collect($req['opportunities']);

        return view('jobs.index', [
            'opportunities' => $opportunities,
        ]);
    }
}
