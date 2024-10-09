<?php

namespace App\Traits;

trait WithFunctionAccess
{
    protected array $permissions = [
        [
            'key' => 'crud-users',
            'value' => 'CRUD users',
            'description' => 'Create, Rename, Update, Delete users of the Hermes system. Typically used by Executive, IT and HR staff when on-boarding and off-boarding staff, acting on requests from managers to change users\' access levels, or changing user names (eg, when married).',
        ],
        [
            'key' => 'access-equipment-import',
            'value' => 'Equipment Import',
            'description' => 'Used by full-time Lighting Technicians working as Production Administrators to import equipment list data in CSV form into specific CurrentRMS Jobs. This tool pokes real data directly into Opportunities in CurrentRMS, so care must be taken!',
        ],
        [
            'key' => 'access-action-stream',
            'value' => 'Action Stream',
            'description' => 'Typically used by the Production Assistant to see what changes have been made to which Jobs in CurrentRMS in certain timeframes. This is "read only" data, and any staff member can be assigned to this function if it would be useful to them.',
        ],
        [
            'key' => 'access-qet',
            'value' => 'QET',
            'description' => '',
        ],
        [
            'key' => 'create-default-discussions',
            'value' => 'Create template Discussions',
            'description' => 'Typically used by the Account Manager to create a set of Discussions for a Job or Project in CurrentRMS.',
        ],
        [
            'key' => 'update-default-discussions',
            'value' => 'Edit default Discussions',
            'description' => 'Typically used by executive staff to edit the details of the Discussions (JSON templates) that get added using the "Create template Discussions" tool.',
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
