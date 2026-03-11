<?php

namespace App\Http\Controllers;

use App\Facades\CurrentRMS;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request_collection = $request->collect();
        $term = $request_collection->get('term');
        $params = $request_collection->forget('term');
        $uri = 'products';

        if ($params->isNotEmpty()) {
            $params = preg_replace('/\[\d+\]/', '[]', str_replace('?', $term, urldecode(http_build_query($params->toArray()))));
            $uri = "{$uri}?{$params}";
        }

        $response = CurrentRMS::fetch($uri);

        if ($response->hasErrors()) {
            return response()->json([]);
        }

        ['products' => $products] = $response->getData();

        if (empty($products)) {
            return response()->json([]);
        };

        return response()->json(array_map(function ($product) {
            return [
                'id' => $product['id'],
                'text' => $product['name'],
                'thumb_url' => $product['icon'] ? $product['icon']['thumb_url'] : '',
            ];
        }, $products));
    }
}
