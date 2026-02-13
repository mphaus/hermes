<?php

namespace App\Traits;

trait WithUserPermissions
{
    /**
     * The permissions array lists all available permissions for users in the system.
     *
     * Each permission is represented as an associative array containing:
     * - value: string   // The unique identifier of the permission
     * - label: string   // A human-readable label for the permission
     * - description: string // A description of the permission and its intended use
     *
     * @var array<int, array{
     *     value: string,
     *     label: string,
     *     description: string
     * }>
     */
    protected array $permissions = [
        [
            'value' => 'crud-users',
            'label' => 'CRUD users',
            'description' => 'Create, Rename, Update, Delete users of the Hermes system. Typically used by Executive, IT and HR staff when on-boarding and off-boarding staff, acting on requests from managers to change users\' access levels, or changing user names (eg, when married).',
        ],
        [
            'value' => 'access-equipment-import',
            'label' => 'Equipment Import',
            'description' => 'Used by full-time Lighting Technicians working as Production Administrators to import equipment list data in CSV form into specific CurrentRMS Jobs. This tool pokes real data directly into Opportunities in CurrentRMS, so care must be taken!',
        ],
        [
            'value' => 'access-action-stream',
            'label' => 'Action Stream',
            'description' => 'Typically used by the Production Assistant to see what changes have been made to which Jobs in CurrentRMS in certain timeframes. This is "read only" data, and any staff member can be assigned to this function if it would be useful to them.',
        ],
        [
            'value' => 'access-qet',
            'label' => 'QET',
            'description' => 'The Quick Equipment Transfers function (QET) is primarily used by Warehouse staff and Production Administrators to see what equipment needs to be quickly transferred to new Jobs in busy periods.',
        ],
        [
            'value' => 'create-default-discussions',
            'label' => 'Create template Discussions',
            'description' => 'Typically used by the Account Manager to create a set of Discussions for a Job or Project in CurrentRMS.',
        ],
        [
            'value' => 'update-default-discussions',
            'label' => 'Edit default Discussions',
            'description' => 'Typically used by executive staff to edit the details of the Discussions (JSON templates) that get added using the "Create template Discussions" tool.',
        ],
        [
            'value' => 'access-quarantine-intake',
            'label' => 'Quarantine Intake',
            'description' => 'Used primarily by Warehouse Technicians and the Production Assistant to submit new quarantine items to CurrentRMS, along with the Opportunity / Project name and Technical Supervisor.',
        ],
        [
            'value' => 'crud-production-administrators',
            'label' => 'Production Administrator CRUD',
            'description' => '',
        ],
        [
            'value' => 'crud-technical-supervisors',
            'label' => 'Technical Supervisor CRUD',
            'description' => 'Used by the Production Assistant to add MPH Technical Supervisors to the drop-down list on the Opportunity / Project edit page in CurrentRMS (this in turn is used to ensure Quarantine items assigned to Jobs are also assigned to Technical Supervisors, so accurate Quarantine reporting is possible).',
        ],
    ];

    /**
     * Get the list of available user permissions.
     *
     * @return array<int, array{value: string, label: string, description: string}>
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Get the label for the specified permission key.
     *
     * @param string $key The permission key to search for.
     * @return string The label associated with the given permission key.
     */
    public function getPermission(string $key)
    {
        $i = array_search($key, array_column($this->permissions, 'value'));
        return $this->permissions[$i]['label'];
    }
}
