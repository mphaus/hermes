<?php

namespace App\Traits;

trait WithFunctionAccess
{
    protected array $permissions = [
        [
            'key' => 'crud-users',
            'value' => 'CRUD users',
        ],
        [
            'key' => 'access-equipment-import',
            'value' => 'Equipment Import',
        ],
        [
            'key' => 'access-action-stream',
            'value' => 'Action Stream',
        ],
        [
            'key' => 'access-qet',
            'value' => 'QET',
        ],
        [
            'key' => 'create-default-discussions',
            'value' => 'Create template Discussions',
        ],
        [
            'key' => 'update-default-discussions',
            'value' => 'Edit default Discussions',
        ],
    ];

    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function getPermission(string $key): string
    {
        $i = array_search($key, array_column($this->permissions, 'key'));

        return $this->permissions[$i]['value'];
    }
}
