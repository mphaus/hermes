<?php

namespace App\Traits;

trait WithActionType
{
    protected array $types = [
        [
            'key' => 'create_item',
            'value' => 'Added item',
        ],
        [
            'key' => 'cancel',
            'value' => 'Cancelled',
        ],
        [
            'key' => 'comment',
            'value' => 'Commented on discussion',
        ],
        [
            'key' => 'discuss',
            'value' => 'Created a discussion',
        ],
        [
            'key' => 'discussion_create',
            'value' => 'Created via discussion email',
        ],
        [
            'key' => 'destroy',
            'value' => 'Deleted',
        ],
        [
            'key' => 'erase',
            'value' => 'Erased',
        ],
        [
            'key' => 'update',
            'value' => 'Updated',
        ],
        [
            'key' => 'mark_as_postponed',
            'value' => 'Marked as postponed',
        ],
        [
            'key' => 'mark_as_dead',
            'value' => 'Marked as dead',
        ],
        [
            'key' => 'mark_as_lost',
            'value' => 'Marked as lost',
        ],
    ];

    public function getActionTypes(): array
    {
        return $this->types;
    }
}
