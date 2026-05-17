<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateProductLabelsRequest;
use Inertia\Inertia;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;

use function Spatie\LaravelPdf\Support\pdf;

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

        $timestamp = now()->timestamp;
        $file_name = "product-labels-{$timestamp}.pdf";

        pdf()
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->setNodeBinary(config('app.browsershot.node_binary'));
                $browsershot->setNpmBinary(config('app.browsershot.npm_binary'));
                $browsershot->setOption('args', [
                    '--disable-web-security',
                    '--allow-file-access-from-files',
                ]);
            })
            ->view('pdf.product-label', ['products' => $products])
            ->landscape()
            ->format(Format::A4)
            ->disk('local')
            ->save("pdf_files/{$file_name}");

        return Inertia::location(route('products.labels.download', ['file' => $file_name]));
    }
}
