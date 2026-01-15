import { InertiaLinkProps } from '@inertiajs/react';

export interface Auth {
    user: User | null;
}

export interface SharedData {
    name: string;
    auth: Auth;
    title?: string;
    description?: string;
    flash?: Record<string, unknown>;
    [key: string]: unknown;
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
    permissions: string[];
    created_at: string;
    updated_at: string;
    [key: string]: unknown; // This allows for additional properties...
}

export interface CurrentRMSListValue {
    id: number;
    list_name_id: number;
    name: string;
    system: boolean;
    default: boolean;
    colour_index: number;
    created_at: string;
    updated_at: string;
};

export interface CurrentRMSMember {
    id: number;
    name: string;
    [key: string]: unknown;
};

export type QuarantineOpportunityType = 'production-lighting-hire' | 'dry-hire' | 'not-associated';

export type QuarantineSerialNumberStatus = 'serial-number-exists' | 'missing-serial-number' | 'not-serialised';

export type QuarantineIntakeLocation = 'on-a-shelf' | 'in-the-bulky-products-area';


