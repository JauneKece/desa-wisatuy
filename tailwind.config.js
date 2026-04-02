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
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
                outfit: ['Outfit', 'sans-serif'],
            },
            colors: {
                brand: {
                    50: '#fff9eb',
                    100: '#fff3c4',
                    200: '#ffe69b',
                    300: '#ffd86e',
                    400: '#ffc93f',
                    500: '#ffb400',
                    600: '#e69e00',
                    700: '#b37700',
                    800: '#805000',
                    900: '#4d2a00',
                },
                slate: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
            },
            animation: {
                'float-up': 'float-up 0.6s ease-out',
                'slide-in-right': 'slide-in-right 0.6s ease-out',
                'slide-in-left': 'slide-in-left 0.6s ease-out',
                'glow-pulse': 'glow-pulse 2s ease-in-out infinite',
                'shimmer': 'shimmer 2s infinite',
                'bounce-gentle': 'bounce-gentle 3s ease-in-out infinite',
                'scale-in': 'scale-in 0.5s ease-out',
            },
            backdropBlur: {
                xs: '2px',
            },
            container: {
                center: true,
                padding: {
                    DEFAULT: '1rem',
                    sm: '1.5rem',
                    lg: '2rem',
                },
            },
        },
    },

    plugins: [forms],
};
