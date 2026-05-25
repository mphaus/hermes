<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductsLabelsCreateSuccessController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $product_labels_download = $request->session()->get('product_labels_download', []);

        if (empty($product_labels_download)) {
            return to_route('products.labels.create');
        }

        return Inertia::render('ProductsLabelsCreateSuccess', [
            'title' => 'Products > Label generation successful',
            'product_labels_download' => $product_labels_download,
        ]);
    }
}
