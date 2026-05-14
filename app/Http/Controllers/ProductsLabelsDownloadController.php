<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsLabelsDownloadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->download(file: storage_path('app/pdf_files/test-product-label.pdf'), headers: [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
