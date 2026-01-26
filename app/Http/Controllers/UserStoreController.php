<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserStoreRequest;

class UserStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UserStoreRequest $request)
    {
        dd(request()->all());
        $request->store();
        return to_route('inertia.users.index');
    }
}
