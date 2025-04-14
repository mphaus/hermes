<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionAdministratorController extends Controller
{
    public function index()
    {
        return view('production-administrator.index');
    }
}
