<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsLabelsDownloadController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $file = $request->input('file');

        if (!$file || !Storage::disk('local')->exists("pdf_files/{$file}")) {
            return to_route('products.labels.create');
        }

        return response()->download(storage_path("app/pdf_files/{$file}"), headers: [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
