<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateProductLabelsRequest;

class ProductsLabelsGenerateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(GenerateProductLabelsRequest $request)
    {
        $validated = $request->validated();

        ['products' => $products] = $validated;

        dd($products);
    }
}
