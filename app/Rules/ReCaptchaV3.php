<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use ReCaptcha\ReCaptcha;

class ReCaptchaV3 implements ValidationRule
{
    private ReCaptcha $recaptcha;

    public function __construct(
        private ?string $hostname = null,
        private ?string $action = null,
        private float $threshold = 0.5
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $this->recaptcha = new ReCaptcha(config('app.recaptcha_v3.secret_key'));

        if ($this->hostname !== null) {
            $this->recaptcha->setExpectedHostname($this->hostname);
        }

        if ($this->action !== null) {
            $this->recaptcha->setExpectedAction($this->action);
        }

        $this->recaptcha->setScoreThreshold($this->threshold);

        $response = $this->recaptcha->verify($value);

        if (!$response->isSuccess()) {
            $fail(trans('auth.recaptcha.failed'));
        }
    }
}
