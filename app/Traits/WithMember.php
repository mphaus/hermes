<?php

namespace App\Traits;

trait WithMember
{
    protected array $members = [
        [
            'id' => 585,
            'name' => 'Michael Parsons',
        ],
        [
            'id' => 586,
            'name' => 'Matthew Hansen',
        ]
    ];

    public function getMembers(): array
    {
        return $this->members;
    }
}
