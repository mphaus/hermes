<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Number;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class EquipmentImportShowControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    public function test_it_requires_authentication(): void
    {
        $response = $this->get(route('inertia.equipment-import.show', ['opportunity_id' => 1001]));

        $response->assertRedirect(route('login'));
    }

    public function test_it_requires_access_equipment_import_permission(): void
    {
        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => [],
        ]);

        $response = $this->actingAs($user)->get(route('inertia.equipment-import.show', ['opportunity_id' => 1001]));

        $response->assertNotFound();
    }

    public function test_it_renders_the_page_and_loads_deferred_opportunity_data(): void
    {
        Http::fake(function (Request $request) {
            if ($request->method() === 'GET' && str_contains($request->url(), 'opportunities/1001')) {
                return Http::response([
                    'opportunity' => [
                        'id' => 1001,
                        'name' => 'Opportunity A',
                        'starts_at' => '2026-04-21T12:00:00+00:00',
                        'ends_at' => '2026-04-22T12:00:00+00:00',
                        'charge_total' => 1234.56,
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

        $response = $this->actingAs($user)->get(route('inertia.equipment-import.show', ['opportunity_id' => 1001]));

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('EquipmentImportShow')
                ->where('title', 'Equipment Import > Import')
                ->has('opportunities_url')
                ->loadDeferredProps(
                    'default',
                    fn(Assert $deferredPage) => $deferredPage
                        ->has('opportunity_data')
                        ->where('opportunity_data.error', '')
                        ->where('opportunity_data.data.id', 1001)
                        ->where('opportunity_data.data.starts_at_formatted', '21-Apr-2026')
                        ->where('opportunity_data.data.ends_at_formatted', '22-Apr-2026')
                        ->where('opportunity_data.data.charge_total_formatted', Number::currency(1234.56))
                )
        );

        Http::assertSentCount(1);
        Http::assertSent(function (Request $request) {
            return $request->method() === 'GET' && str_contains($request->url(), 'opportunities/1001');
        });
    }

    public function test_it_returns_error_payload_when_current_rms_fails_for_deferred_data(): void
    {
        Http::fake(function (Request $request) {
            if ($request->method() === 'GET' && str_contains($request->url(), 'opportunities/1001')) {
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

        $response = $this->actingAs($user)->get(route('inertia.equipment-import.show', ['opportunity_id' => 1001]));

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('EquipmentImportShow')
                ->loadDeferredProps(
                    'default',
                    fn(Assert $deferredPage) => $deferredPage
                        ->has('opportunity_data')
                        ->where('opportunity_data.data', [])
                        ->where('opportunity_data.error', fn($error) => is_string($error) && $error !== '')
                )
        );

        Http::assertSentCount(1);
        Http::assertSent(function (Request $request) {
            return $request->method() === 'GET' && str_contains($request->url(), 'opportunities/1001');
        });
    }
}
