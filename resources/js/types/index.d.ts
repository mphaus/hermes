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

export type CurrentRMSListName = {
    id: number;
    name: string;
    system: boolean;
    has_colour: boolean;
    created_at: string;
    updated_at: string;
    list_values: CurrentRMSListValue[];
};

export type CurrentRMSMeta = {
    'can_edit?': boolean;
    'can_destroy?': boolean;
};
export interface CurrentRMSListData {
    list_name?: CurrentRMSListName;
    meta?: CurrentRMSMeta,
    errors?: CurrentRMSError;
}
