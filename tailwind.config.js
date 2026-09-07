import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
const colors = require('tailwindcss/colors')

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./vendor/wireui/wireui/src/*.php",
        "./vendor/wireui/wireui/ts/**/*.ts",
        "./vendor/wireui/wireui/src/WireUi/**/*.php",
        "./vendor/wireui/wireui/src/Components/**/*.php",
    ],

    safelist: [
        'bg-note-sage', 'bg-note-pink', 'bg-note-mint',
        'bg-note-peach', 'bg-note-lilac', 'bg-note-sky',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: colors.red,
                note: {
                    sage: '#E8F0D9',
                    pink: '#FBDCEA',
                    mint: '#D6EFD8',
                    peach: '#FDE8C8',
                    lilac: '#E7E0F8',
                    sky: '#DCEBFA',
                },
            },
            keyframes: {
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(16px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'pop-in': {
                    '0%': { opacity: '0', transform: 'scale(.6)' },
                    '60%': { opacity: '1', transform: 'scale(1.06)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                'card-out': {
                    '0%': { opacity: '1', transform: 'scale(1) translateY(0)' },
                    '100%': { opacity: '0', transform: 'scale(.9) translateY(-8px)' },
                },
                'orb-drift': {
                    '0%': { transform: 'translate(0, 0) scale(1)' },
                    '50%': { transform: 'translate(18px, -24px) scale(1.08)' },
                    '100%': { transform: 'translate(0, 0) scale(1)' },
                },
                'orb-pulse': {
                    '0%, 100%': { opacity: '0.55' },
                    '50%': { opacity: '0.9' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-400px 0' },
                    '100%': { backgroundPosition: '400px 0' },
                },
                wiggle: {
                    '0%, 100%': { transform: 'rotate(-6deg)' },
                    '50%': { transform: 'rotate(6deg)' },
                },
                'underline-grow': {
                    '0%': { transform: 'scaleX(0)' },
                    '100%': { transform: 'scaleX(1)' },
                },
                'float-y': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-6px)' },
                },
            },
            animation: {
                'fade-up': 'fade-up .5s cubic-bezier(.21,1.02,.73,1) both',
                'pop-in': 'pop-in .45s cubic-bezier(.34,1.56,.64,1) both',
                'card-out': 'card-out .3s ease-in both',
                'orb-drift': 'orb-drift 14s ease-in-out infinite',
                'orb-drift-slow': 'orb-drift 20s ease-in-out infinite',
                'orb-pulse': 'orb-pulse 6s ease-in-out infinite',
                shimmer: 'shimmer 1.6s linear infinite',
                wiggle: 'wiggle 3s ease-in-out infinite',
                'underline-grow': 'underline-grow .25s ease-out both',
                'float-y': 'float-y 3.5s ease-in-out infinite',
            },
        },
    },

    presets: [
        require("./vendor/wireui/wireui/tailwind.config.js")
    ],

    plugins: [forms],
};
