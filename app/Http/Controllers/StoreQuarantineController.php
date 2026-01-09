<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuarantineRequest;
use Illuminate\Http\Request;

class StoreQuarantineController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreQuarantineRequest $request)
    {
        $request->store();
    }
}
