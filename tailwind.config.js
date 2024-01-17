import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        container: {
            center: true,
            padding: '1rem',
        },
        extend: {
            fontFamily: {
                sans: [ 'Figtree', ...defaultTheme.fontFamily.sans ],
            },
            colors: {
                primary: {
                    100: "#f2d6dd",
                    200: "#e5aebb",
                    300: "#d88599",
                    400: "#cb5d77",
                    500: "#be3455",
                    600: "#982a44",
                    700: "#721f33",
                    800: "#4c1522",
                    900: "#260a11"
                },
            }
        },
    },

    plugins: [ forms ],
};
