<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscussionRequest;
use App\Models\DiscussionMapping;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function create(): View
    {
        return view('discussion.create', [
            'config' => DiscussionMapping::latest()->first(),
        ]);
    }

    public function store(StoreDiscussionRequest $request)
    {
        $request->store();
    }
}
