<?php

namespace App\Traits;

trait WithQuarantineIntakeClassification
{
    protected array $_classification = [
        [
            'text' => 'Dangerous for people to handle or be around',
            'example' => 'For example, risk of electric shock, or being cut by glass.',
        ],
        [
            'text' => 'Cannot deliver results expected by Client',
            'example' => 'For example, flickering LEDs, or does not zoom or no tilt.',
        ],
        [
            'text' => 'Incorrectly commissioned',
            'example' => 'For example, needs re-painting or re-branding or new Test & Tag.',
        ],
        [
            'text' => 'Does not meet MPH quality standard',
            'example' => 'For example, cracked or missing panels, bent metal, water ingress.',
        ],
    ];

    public function getClassification(): array
    {
        return $this->_classification;
    }

    public function getClassificationTexts(): array
    {
        return array_map(fn($classification) => $classification['text'], $this->_classification);
    }
}
