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
                coffee: {
                    50: '#fbf8f5',
                    100: '#f6ede4',
                    200: '#ebdccf',
                    300: '#dec2ab',
                    400: '#cea282',
                    500: '#be8560',
                    600: '#a86d49',
                    700: '#8c563b',
                    800: '#724634',
                    900: '#5c392c',
                    950: '#331c15',
                },
            },
        },
    },

    plugins: [forms],
};
