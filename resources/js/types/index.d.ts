import { InertiaLinkProps } from '@inertiajs/react';

export interface Auth {
    user: User | null;
}

export interface SharedData {
    name: string;
    auth: Auth;
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
