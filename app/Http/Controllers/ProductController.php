<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function search(Request $request)
    {
        $response = Http::current()
            ->withQueryParameters([
                'per_page' => 20,
                'q[name_cont]' => $request->get('q'),
            ])
            ->get('products');

        ['products' => $products] = $response->json();

        if (empty($products)) {
            return [];
        }

        return array_map(fn($product) => [
            'id' => $product['id'],
            'text' => $product['name'],
            'thumb_url' => $product['icon'] ? $product['icon']['thumb_url'] : '',
        ], $products);
    }
}
