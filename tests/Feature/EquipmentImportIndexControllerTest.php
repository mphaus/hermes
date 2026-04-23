<?php

namespace Tests\Feature;

use App\Enums\JobStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EquipmentImportIndexControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    public function test_it_requires_authentication(): void
    {
        $response = $this->get(route('inertia.equipment-import'));

        $response->assertRedirect(route('login'));
    }

    public function test_it_requires_access_equipment_import_permission(): void
    {
        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => [],
        ]);

        $response = $this->actingAs($user)->get(route('inertia.equipment-import'));

        $response->assertNotFound();
    }

    public function test_it_renders_the_page_and_loads_deferred_opportunities_data(): void
    {
        Http::fake(function (Request $request) {
            if ($request->method() === 'GET' && str_contains($request->url(), 'opportunities')) {
                return Http::response([
                    'opportunities' => [
                        [
                            'id' => 1001,
                            'name' => 'Opportunity A',
                            'starts_at' => '2026-04-21T12:00:00+00:00',
                            'ends_at' => '2026-04-22T12:00:00+00:00',
                        ],
                    ],
                    'meta' => [
                        'total_row_count' => 1,
                        'per_page' => 25,
                    ],
                ], 200);
            }

            return null;
        });

        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => true,
            'permissions' => [],
        ]);

        $response = $this->actingAs($user)->get(route('inertia.equipment-import'));

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('EquipmentImportIndex')
                ->where('title', 'Equipment Import')
                ->where('description', 'Opportunities in CurrentRMS with the state of <strong>Order</strong> and <strong>Open</strong>.')
                ->loadDeferredProps(
                    'default',
                    fn(Assert $deferredPage) => $deferredPage
                        ->has('opportunities_data')
                        ->where('opportunities_data.error', '')
                        ->where('opportunities_data.current_page', 1)
                        ->where('opportunities_data.per_page', 25)
                        ->where('opportunities_data.total', 1)
                        ->has('opportunities_data.data', 1)
                        ->where('opportunities_data.data.0.id', 1001)
                        ->where('opportunities_data.data.0.starts_at_formatted', '21-Apr-2026')
                        ->where('opportunities_data.data.0.ends_at_formatted', '22-Apr-2026')
                        ->has('opportunities_data.links')
                )
        );

        Http::assertSentCount(1);
        Http::assertSent(function (Request $request) {
            if (!str_contains($request->url(), 'opportunities')) {
                return false;
            }

            if ($request->method() !== 'GET') {
                return false;
            }

            $url = $request->url();

            return str_contains($url, 'page=1')
                && str_contains($url, 'per_page=25')
                && str_contains($url, 'filtermode=orders')
                && str_contains($url, 'q%5Bstatus_eq%5D=' . JobStatus::Open->value);
        });
    }

    public function test_it_returns_error_payload_when_current_rms_fails_for_deferred_data(): void
    {
        Http::fake(function (Request $request) {
            if ($request->method() === 'GET' && str_contains($request->url(), 'opportunities')) {
                return Http::response([
                    'errors' => ['CurrentRMS unavailable'],
                ], 500);
            }

            return null;
        });

        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => true,
            'permissions' => [],
        ]);

        $response = $this->actingAs($user)->get(route('inertia.equipment-import'));

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('EquipmentImportIndex')
                ->loadDeferredProps(
                    'default',
                    fn(Assert $deferredPage) => $deferredPage
                        ->has('opportunities_data')
                        ->where('opportunities_data.data', [])
                        ->where('opportunities_data.error', fn($error) => is_string($error) && $error !== '')
                )
        );

        Http::assertSentCount(1);
    }
}
