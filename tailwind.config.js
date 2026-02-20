import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import daisyui from 'daisyui';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class', // Enable dark mode with class strategy
    
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#6A0404',
                    50: '#FEE2E2',
                    100: '#FEE2E2',
                    200: '#FECACA',
                    300: '#FCA5A5',
                    400: '#F87171',
                    500: '#EF4444',
                    600: '#DC2626',
                    700: '#991B1B',
                    800: '#7F1D1D',
                    900: '#6A0404',
                    950: '#450303',
                },
            },
        },
    },

    plugins: [forms, daisyui],
    
    daisyui: {
        themes: [
            {
                light: {
                    "primary": "#6A0404",
                    "secondary": "#991B1B",
                    "accent": "#DC2626",
                    "neutral": "#3d4451",
                    "base-100": "#ffffff",
                    "info": "#3abff8",
                    "success": "#36d399",
                    "warning": "#fbbd23",
                    "error": "#f87272",
                },
                dark: {
                    "primary": "#DC2626",
                    "secondary": "#991B1B",
                    "accent": "#EF4444",
                    "neutral": "#2a2e37",
                    "base-100": "#1f2937",
                    "info": "#3abff8",
                    "success": "#36d399",
                    "warning": "#fbbd23",
                    "error": "#f87272",
                },
            },
        ],
        darkTheme: "dark",
        base: true,
        styled: true,
        utils: true,
        logs: false,
    },
};
