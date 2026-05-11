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

        $products = collect($products)->map(function (array $product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'],
                'icon_url' => $product['icon']['url'] ?? 'https://placehold.co/600x600?text=No+image',
                'colour_coded_storage' => $product['custom_fields']['colour_coded_storage'] ?? null,
                'nally_bin_storage' => $product['custom_fields']['nally_bin_storage'] ?? null,
                'nally_bin_storage_stored_at_height' => $product['custom_fields']['nally_bin_storage_stored_at_height'] ?? null,
                'tub_storage' => $product['custom_fields']['tub_storage'] ?? null,
            ];
        });

        dd($products);
    }
}
