<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductionAdministratorRequest;
use Illuminate\Contracts\View\View;

class ProductionAdministratorController extends Controller
{
    public function index(): View
    {
        return view('production-administrator.index');
    }

    public function create(): View
    {
        return view('production-administrator.create');
    }

    public function store(ProductionAdministratorRequest $request)
    {
        $request->validated();
        $request->store();
    }
}
