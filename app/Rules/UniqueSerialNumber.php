<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class UniqueSerialNumber implements ValidationRule
{
    public function __construct(
        private string $serial_number_status = ''
    ) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->serial_number_status === 'serial-number-exists') {
            $response = Http::current()->withQueryParameters(['q[reference_eq]' => $value])->get('quarantines');

            if ($response->failed()) {
                $fail(__('An error occurred while checking if an active Quarantine already exists with this serial number, please refresh the page and try again.'));
            }

            ['meta' => $meta] = $response->json();

            if ($meta['total_row_count'] > 0) {
                $fail(__('An active Quarantine already exists with this serial number'));
            }
        }
    }
}