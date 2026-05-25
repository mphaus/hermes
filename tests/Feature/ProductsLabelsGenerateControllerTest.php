<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelPdf\Facades\Pdf;
use Tests\TestCase;

class ProductsLabelsGenerateControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Pdf::fake();
        Storage::fake('local');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_it_requires_authentication(): void
    {
        $response = $this->post(route('products.labels.store'), $this->validPayload());

        $response->assertRedirect(route('login'));
    }

    public function test_it_requires_the_create_product_labels_permission(): void
    {
        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => [],
        ]);

        $response = $this->actingAs($user)->post(route('products.labels.store'), $this->validPayload());

        $response->assertNotFound();
    }

    public function test_it_generates_a_pdf_and_redirects_to_the_success_page(): void
    {
        $now = Carbon::create(2026, 5, 25, 12, 34, 56, 'UTC');
        Carbon::setTestNow($now);

        $expectedFileName = 'product-labels-' . $now->timestamp . '.pdf';

        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => ['create-product-labels'],
        ]);

        $response = $this->actingAs($user)->post(route('products.labels.store'), $this->validPayload());

        $response->assertRedirect(route('products.labels.create.success'));
        $response->assertSessionHas('product_labels_download', function (array $download) use ($expectedFileName) {
            return $download['filename'] === $expectedFileName
                && $download['url'] === route('products.labels.download', ['file' => $expectedFileName]);
        });

        Pdf::assertSaved(function ($pdf, string $path) use ($expectedFileName) {
            return $path === 'pdf_files/' . $expectedFileName
                && $pdf->viewName === 'pdf.product-label'
                && isset($pdf->viewData['products'][0])
                && $pdf->viewData['products'][0]['id'] === 101
                && $pdf->viewData['products'][0]['title'] === 'Beam'
                && $pdf->viewData['products'][0]['subtitle'] === '2m'
                && $pdf->viewData['products'][0]['label_type'] === 'color'
                && $pdf->viewData['products'][0]['highlight_classes'] === 'bg-purple-600 text-white p-2';
        });

        expect(Storage::disk('local')->allFiles('pdf_files'))->toBeEmpty();
    }

    public function test_it_rejects_an_empty_products_array(): void
    {
        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => ['create-product-labels'],
        ]);

        $response = $this->actingAs($user)->post(route('products.labels.store'), [
            'products' => [],
        ]);

        $response->assertSessionHasErrors('products');
        expect(Storage::disk('local')->allFiles('pdf_files'))->toBeEmpty();
    }

    public function test_it_rejects_a_malformed_product_payload(): void
    {
        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => ['create-product-labels'],
        ]);

        $response = $this->actingAs($user)->post(route('products.labels.store'), $this->validPayload([
            'name' => null,
        ]));

        $response->assertSessionHasErrors('products');
        expect(Storage::disk('local')->allFiles('pdf_files'))->toBeEmpty();
    }

    private function validPayload(array $productOverrides = []): array
    {
        $product = array_replace_recursive([
            'id' => 101,
            'name' => 'Beam - 2m',
            'icon' => [
                'url' => 'https://example.test/beam.png',
            ],
            'custom_fields' => [
                'colour_coded_storage' => 'Yes',
                'nally_bin_storage' => 'No',
                'nally_bin_storage_stored_at_height' => 'No',
                'tub_storage' => 'No',
            ],
        ], $productOverrides);

        return [
            'products' => [$product],
        ];
    }
}
