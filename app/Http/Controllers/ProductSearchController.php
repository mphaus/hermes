<?php

namespace App\Http\Controllers;

use App\Services\CurrentRMSApiService;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    public function __construct(
        protected CurrentRMSApiService $currentrms
    ) {}

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

        $products_data = $this->currentrms->fetch($uri);

        if (isset($products_data['errors'])) {
            return response()->json([]);
        }

        ['products' => $products] = $products_data;

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
