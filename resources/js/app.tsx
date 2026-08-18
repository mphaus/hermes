import { createInertiaApp } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Layout from "./layouts/Layout";

const appName = import.meta.env.VITE_APP_NAME || 'Hermes';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: async (name) => {
        const page: any = await resolvePageComponent(`./pages/${name}.tsx`, import.meta.glob('./pages/**/*.tsx'));
        page.default.layout = page.default.layout || ((page: React.ReactNode) => <Layout children={page} />)

        return page;
    },
    progress: {
        color: '#4B5563',
    },
});
