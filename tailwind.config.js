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
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'primary-dark': '#1f1f21'
            },
            screens: {
                "1120px": {
                    "max": "1120px"
                },
                "1000px": {
                    "max": "1000px"
                },
                "980px": {
                    "max": "980px"
                },
                "900px": {
                    "max": "900px"
                },
                "850px": {
                    "max": "850px"
                },
                "680px": {
                    "max": "680px"
                },
                "580px": {
                    "max": "580px"
                },
                "500px": {
                    "max": "500px"
                },
                "460px": {
                    "max": "460px"
                },
                "440px": {
                    "max": "440px"
                }
            }
        },
    },

    plugins: [forms],
};
