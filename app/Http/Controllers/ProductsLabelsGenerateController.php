<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateProductLabelsRequest;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Illuminate\Validation\ValidationException;

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

            $full_product_name = $product['name'] ?? '';
            $highlight_classes = $label_type === 'color'
                ? $this->highlightClassesForLabelText($full_product_name)
                : '';

            $name_parts = explode(' - ', $full_product_name);
            $title = $name_parts[0] ?? '';
            $subtitle = $name_parts[1] ?? '';

            return [
                'id' => $product['id'],
                'title' => $title,
                'subtitle' => $subtitle,
                'icon_url' => $product['icon']['url'] ?? 'https://placehold.co/600x600?text=No+image',
                'label_type' => $label_type,
                'highlight_classes' => $highlight_classes,
            ];
        })->filter(function (array $product) {
            return $product['label_type'] !== '';
        })->values();

        if ($products->isEmpty()) {
            throw ValidationException::withMessages([
                'products' => __('The selected products do not match any of the Storage Container Types established in CurrentRMS.'),
            ]);
        }

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

        session()->flash('product_labels_download', [
            'url' => route('products.labels.download', ['file' => $file_name]),
            'filename' => $file_name,
        ]);

        return to_route('products.labels.create.success');
    }

    private function highlightClassesForLabelText(string $value): string
    {
        $length_in_metres = $this->extractLengthInMetres($value);

        if ($length_in_metres === null) {
            return '';
        }

        return match (true) {
            $length_in_metres === 2 => 'bg-purple-600 text-white p-2',
            $length_in_metres >= 5 && $length_in_metres <= 9 => 'bg-red-600 text-white p-2',
            $length_in_metres >= 10 && $length_in_metres <= 14 => 'bg-blue-600 text-white p-2',
            $length_in_metres >= 15 && $length_in_metres <= 19 => 'bg-green-600 text-white p-2',
            $length_in_metres >= 20 && $length_in_metres <= 24 => 'bg-yellow-400 text-black p-2',
            $length_in_metres >= 25 && $length_in_metres <= 29 => 'bg-red-600 text-white p-2',
            $length_in_metres >= 30 && $length_in_metres <= 39 => 'bg-orange-500 text-white p-2',
            $length_in_metres >= 40 && $length_in_metres <= 49 => 'bg-amber-800 text-white p-2',
            $length_in_metres >= 50 && $length_in_metres <= 79 => 'bg-gray-400 text-black p-2',
            default => '',
        };
    }

    private function extractLengthInMetres(string $value): ?int
    {
        if (! preg_match('/(?<![\d.])(\d+)m$/i', rtrim($value), $matches)) {
            return null;
        }

        return (int) $matches[1];
    }
}
