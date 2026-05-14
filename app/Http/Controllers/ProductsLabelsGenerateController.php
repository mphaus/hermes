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
            $custom_fields = $product['custom_fields'] ?? [];

            if (($custom_fields['tub_storage'] ?? null) === 'Yes' || ($custom_fields['nally_bin_storage'] ?? null) === 'Yes') {
                $label_type = 'tub_or_nally_bin';
            } elseif (($custom_fields['colour_coded_storage'] ?? null) === 'Yes') {
                $label_type = 'color';
            } elseif (($custom_fields['nally_bin_storage_stored_at_height'] ?? null) === 'Yes') {
                $label_type = 'stored_at_height';
            } else {
                $label_type = '';
            }

            $name_parts = explode(' - ', $product['name'] ?? '');
            $title = $name_parts[0] ?? '';
            $subtitle = $name_parts[1] ?? '';

            return [
                'id' => $product['id'],
                'title' => $title,
                'subtitle' => $subtitle,
                'icon_url' => $product['icon']['url'] ?? 'https://placehold.co/600x600?text=No+image',
                'label_type' => $label_type,
            ];
        })->filter(function (array $product) {
            return $product['label_type'] !== '';
        })->values();

        dd($products);
    }
}
