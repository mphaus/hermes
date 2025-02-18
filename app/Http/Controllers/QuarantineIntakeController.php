<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuarantineIntakeController extends Controller
{
    public function success()
    {
        return view('quarantine-intake-success');
    }
}
