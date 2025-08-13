import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue', // If using Vue
        './resources/js/**/*.js',  // If using JS components
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#1E40AF', // Example blue
                secondary: '#64748B', // Example gray
                accent: '#F59E0B', // Example amber
                danger: '#DC2626', // Red
                success: '#16A34A', // Green
                // Add any other brand colors you want
            },
        },
    },

    plugins: [forms],
};

