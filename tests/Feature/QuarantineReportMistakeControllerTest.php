<?php

use App\Mail\QuarantineReportMistakeCreated;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

function validReportMistakeData(array $overrides = []): array
{
    return [
        'submitted' => '26-Feb-2025 at 14:30',
        'quarantine_id' => '999',
        'job' => 'Test Job',
        'product' => 'Test Product',
        'serial' => 'SN123456',
        'ready_for_repairs' => '26-Feb-2025 at 14:30',
        'primary_fault_classification' => 'Dangerous for people to handle or be around',
        'fault_description' => 'Test fault description',
        'intake_location' => 'A-1',
        'message' => 'This is a test correction message.',
        ...$overrides,
    ];
}

beforeEach(function () {
    Mail::fake();

    Config::set('app.mph.service_manager_mail_address', 'service-manager@example.com');

    $this->user = User::factory()->create([
        'first_name' => 'Jane',
        'last_name' => 'Doe',
        'is_enabled' => true,
        'is_admin' => true,
        'permissions' => [],
    ]);
});

describe('QuarantineReportMistakeController', function () {
    it('requires authentication', function () {
        $response = $this->post(route('quarantine.report-mistake'), validReportMistakeData());

        $response->assertRedirect();
        expect($response->isRedirect())->toBeTrue();
    });

    it('requires the access-quarantine-intake permission', function () {
        $user = User::factory()->create([
            'is_enabled' => true,
            'is_admin' => false,
            'permissions' => [],
        ]);

        $response = $this->actingAs($user)->post(route('quarantine.report-mistake'), validReportMistakeData());

        $response->assertNotFound();
    });

    it('sends the report email, forgets quarantine session, flashes toast, and redirects to quarantine create', function () {
        $sessionQuarantine = [
            'id' => 999,
            'created_at' => now()->toIso8601String(),
            'starts_at' => now()->toIso8601String(),
        ];

        $response = $this->actingAs($this->user)
            ->withSession(['quarantine' => $sessionQuarantine])
            ->post(route('quarantine.report-mistake'), validReportMistakeData());

        $response->assertRedirect(route('quarantine.create'));
        $response->assertSessionMissing('quarantine');
        $response->assertSessionHas('inertia.flash_data', function ($flash) {
            return isset($flash['toast'])
                && $flash['toast']['type'] === 'success'
                && $flash['toast']['message'] === 'Your report has been sent successfully to the Service Manager.';
        });

        Mail::assertSent(QuarantineReportMistakeCreated::class, function (QuarantineReportMistakeCreated $mail) {
            $validated = validReportMistakeData();
            return $mail->quarantine === $validated
                && $mail->user->is($this->user)
                && $mail->hasTo('service-manager@example.com');
        });
    });

    describe('validation', function () {
        it('requires message field', function () {
            $data = validReportMistakeData(['message' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('message');
        });

        it('validates message max length is 512 characters', function () {
            $data = validReportMistakeData(['message' => str_repeat('a', 513)]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('message');
        });

        it('requires submitted field', function () {
            $data = validReportMistakeData(['submitted' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('submitted');
        });

        it('requires quarantine_id field', function () {
            $data = validReportMistakeData(['quarantine_id' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('quarantine_id');
        });

        it('requires job field', function () {
            $data = validReportMistakeData(['job' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('job');
        });

        it('requires product field', function () {
            $data = validReportMistakeData(['product' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('product');
        });

        it('requires serial field', function () {
            $data = validReportMistakeData(['serial' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('serial');
        });

        it('requires ready_for_repairs field', function () {
            $data = validReportMistakeData(['ready_for_repairs' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('ready_for_repairs');
        });

        it('requires primary_fault_classification field', function () {
            $data = validReportMistakeData(['primary_fault_classification' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('primary_fault_classification');
        });

        it('requires fault_description field', function () {
            $data = validReportMistakeData(['fault_description' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('fault_description');
        });

        it('requires intake_location field', function () {
            $data = validReportMistakeData(['intake_location' => null]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertSessionHasErrors('intake_location');
        });

        it('accepts valid data with message at max length', function () {
            $data = validReportMistakeData(['message' => str_repeat('a', 512)]);

            $response = $this->actingAs($this->user)->post(route('quarantine.report-mistake'), $data);

            $response->assertRedirect(route('quarantine.create'));
            $response->assertSessionDoesntHaveErrors();
            Mail::assertSent(QuarantineReportMistakeCreated::class);
        });
    });
});
