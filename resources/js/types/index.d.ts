import { InertiaLinkProps } from '@inertiajs/react';

export interface Auth {
    user: User | null;
}

export interface SharedData {
    name: string;
    auth: Auth;
    title?: string;
    description?: string;
    [ key: string ]: unknown;
}

export interface User {
    id: number;
    first_name: string;
    last_name: string;
    username: string;
    email: string;
    email_verified_at: string | null;
    is_admin: boolean,
    is_enabled: boolean,
    created_at: string;
    updated_at: string;
    [ key: string ]: unknown; // This allows for additional properties...
}

export type CurrentRMSError = string[];

export type CurrentRMSListValue = {
    id: number;
    list_name_id: number;
    name: string;
    system: boolean;
    default: boolean;
    colour_index: number;
    created_at: string;
    updated_at: string;
};

export type CurrentRMSListData = {
    list_name?: {
        id: number;
        name: string;
        system: boolean;
        has_colour: boolean;
        created_at: string;
        updated_at: string;
        list_values: CurrentRMSListValue[];
    };
    meta?: {
        'can_edit?': boolean;
        'can_destroy?': boolean;
    },
    errors?: CurrentRMSError;
}

export type QuarantineOpportunityType = 'production-lighting-hire' | 'dry-hire' | 'not-associated';

export type CurrentRMSMember = {
    id: number;
    name: string;
    [ key: string ]: unknown;
};

export type CurrentRMSMemberData = {
    members?: CurrentRMSMember[];
    meta?: {
        page: number;
        per_page: number;
        row_count: number;
        total_row_count: number;
    };
    errors?: CurrentRMSError;
};
