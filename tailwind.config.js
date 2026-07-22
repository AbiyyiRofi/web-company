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
            // Semua warna diambil dari CSS variables di resources/css/app.css (:root)
            // -> ganti warna resmi PDAM cukup edit variabelnya di satu tempat, tidak perlu ubah di tiap file.
            colors: {
                primary: {
                    50:  'rgb(var(--c-primary-50) / <alpha-value>)',
                    100: 'rgb(var(--c-primary-100) / <alpha-value>)',
                    200: 'rgb(var(--c-primary-200) / <alpha-value>)',
                    300: 'rgb(var(--c-primary-300) / <alpha-value>)',
                    400: 'rgb(var(--c-primary-400) / <alpha-value>)',
                    500: 'rgb(var(--c-primary-500) / <alpha-value>)',
                    600: 'rgb(var(--c-primary-600) / <alpha-value>)',
                    700: 'rgb(var(--c-primary-700) / <alpha-value>)',
                    800: 'rgb(var(--c-primary-800) / <alpha-value>)',
                    900: 'rgb(var(--c-primary-900) / <alpha-value>)',
                    950: 'rgb(var(--c-primary-950) / <alpha-value>)',
                },
                accent: {
                    300: 'rgb(var(--c-accent-300) / <alpha-value>)',
                    400: 'rgb(var(--c-accent-400) / <alpha-value>)',
                    500: 'rgb(var(--c-accent-500) / <alpha-value>)',
                    600: 'rgb(var(--c-accent-600) / <alpha-value>)',
                },
                ink: {
                    50:  'rgb(var(--c-ink-50) / <alpha-value>)',
                    100: 'rgb(var(--c-ink-100) / <alpha-value>)',
                    400: 'rgb(var(--c-ink-400) / <alpha-value>)',
                    600: 'rgb(var(--c-ink-600) / <alpha-value>)',
                    800: 'rgb(var(--c-ink-800) / <alpha-value>)',
                    900: 'rgb(var(--c-ink-900) / <alpha-value>)',
                    950: 'rgb(var(--c-ink-950) / <alpha-value>)',
                },
            },
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                display: ['"Space Grotesk"', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                soft: '0 2px 20px -4px rgb(15 23 42 / 0.08)',
                lift: '0 20px 40px -12px rgb(15 23 42 / 0.18)',
                glow: '0 0 0 1px rgb(var(--c-accent-400) / 0.4), 0 0 24px -4px rgb(var(--c-accent-400) / 0.55)',
            },
            backgroundImage: {
                'grid-faint': 'linear-gradient(rgb(255 255 255 / 0.06) 1px, transparent 1px), linear-gradient(90deg, rgb(255 255 255 / 0.06) 1px, transparent 1px)',
            },
            keyframes: {
                'fade-up': { '0%': { opacity: 0, transform: 'translateY(16px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
                'fade-in': { '0%': { opacity: 0 }, '100%': { opacity: 1 } },
                'scale-in': { '0%': { opacity: 0, transform: 'scale(.96)' }, '100%': { opacity: 1, transform: 'scale(1)' } },
                shimmer: { '0%': { backgroundPosition: '-200% 0' }, '100%': { backgroundPosition: '200% 0' } },
                'pulse-ring': { '0%': { transform: 'scale(.9)', opacity: .6 }, '80%,100%': { transform: 'scale(1.6)', opacity: 0 } },
            },
            animation: {
                'fade-up': 'fade-up .7s cubic-bezier(.16,1,.3,1) forwards',
                'fade-in': 'fade-in .5s ease forwards',
                'scale-in': 'scale-in .4s cubic-bezier(.16,1,.3,1) forwards',
                shimmer: 'shimmer 2.2s linear infinite',
                'pulse-ring': 'pulse-ring 1.8s cubic-bezier(0,0,.2,1) infinite',
            },
        },
    },

    plugins: [forms],
};
