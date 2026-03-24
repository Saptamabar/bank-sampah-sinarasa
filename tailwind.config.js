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
                sans: ['Inter', 'Nunito', ...defaultTheme.fontFamily.sans],
                heading: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    dark: '#2D6A4F',
                    DEFAULT: '#40916C',
                    light: '#74C69D',
                    accent: '#F4A261',
                }
            }
        },
    },

    plugins: [forms],
};
