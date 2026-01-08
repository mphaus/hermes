<?php

namespace App\Rules;

use App\Services\CurrentRMSApiService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
// use Illuminate\Support\Facades\Http;

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
            // $response = Http::current()->withQueryParameters(['q[reference_eq]' => $value])->get('quarantines');

            // if ($response->failed()) {
            //     $fail(__('An error occurred while checking if an active Quarantine already exists with this serial number, please refresh the page and try again.'), null);
            // }

            // ['meta' => $meta] = $response->json();

            // if ($meta['total_row_count'] > 0) {
            //     $fail(__('<p>💥Ooops! There\'s been a "serial number collision" - an item with this serial number is already registered in Quarantine.</p><p>That\'s not... great 🫣. To move forward, add "-B" to the end of the serial number you entered above, and mention the problem in the Fault Description below. The SRMM team will sort it out. </p>'), null);
            // }

            $currentrms = new CurrentRMSApiService();
            $quarantine_data = $currentrms->fetch('quarantines', ['q' => [
                'reference_eq' => $value,
            ]]);

            if (isset($quarantine_data['errors'])) {
                $fail(__('An error occurred while checking if an active Quarantine already exists with this serial number, please refresh the page and try again.'), null);
            }

            ['meta' => $meta] = $quarantine_data;

            if ($meta['total_row_count'] > 0) {
                $fail(__('<p>💥Ooops! There\'s been a "serial number collision" - an item with this serial number is already registered in Quarantine.</p><p>That\'s not... great 🫣. To move forward, add "-B" to the end of the serial number you entered above, and mention the problem in the Fault Description below. The SRMM team will sort it out. </p>'), null);
            }
        }
    }
}
