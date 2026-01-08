<?php

namespace App\Traits;

trait WithQuarantineFaultClassification
{
    protected array $classifcations = [
        [
            'value' => 'Dangerous for people to handle or be around',
            'label' => 'Dangerous for people to handle or be around',
            'example' => 'For example, risk of electric shock, or being cut by glass.',
        ],
        [
            'value' => 'Cannot deliver results expected by Client',
            'label' => 'Cannot deliver results expected by Client',
            'example' => 'For example, flickering LEDs, or does not zoom or no tilt.',
        ],
        [
            'value' => 'Incorrectly commissioned',
            'label' => 'Incorrectly commissioned',
            'example' => 'For example, needs re-painting or re-branding or new Test & Tag.',
        ],
        [
            'value' => 'Does not meet MPH quality standard',
            'label' => 'Does not meet MPH quality standard',
            'example' => 'For example, cracked or missing panels, bent metal, water ingress.',
        ],
    ];

    public function getFaultClassifications(): array
    {
        return $this->classifcations;
    }

    public function getFaultClassificationValues(): array
    {
        return array_map(fn($classification) => $classification['value'], $this->classifcations);
    }
}
