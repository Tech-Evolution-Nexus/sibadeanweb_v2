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
                outfit: ['Outfit', ...defaultTheme.fontFamily.sans],
                // sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                sans: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            // fontSize: {
            //     'sm': ['14px', '20px'],        // text-sm
            //     'base': ['16px', '24px'],      // text-base
            //     'lg': ['20px', '28px'],        // text-lg
            //     'xl': ['24px', '32px'],        // text-xl
            //     '2xl': ['30px', '38px'],       // text-2xl
            //     '3xl': ['36px', '44px'],       // text-3xl
            //     '4xl': ['48px', '60px'],       // text-4xl
            //     '5xl': ['60px', '72px'],       // text-5xl
            //     '6xl': ['72px', '90px'],       // text-6xl
            //   }
            fontSize: {
                'xs': ['10px', '14px'],       // default: 0.75rem (12px)
                'sm': ['12px', '18px'],       // default: 0.875rem (14px)
                'base': ['14px', '20px'],     // default: 1rem (16px)
                'lg': ['16px', '24px'],       // default: 1.125rem (18px)
                'xl': ['18px', '26px'],       // default: 1.25rem (20px)
                '2xl': ['20px', '28px'],      // default: 1.5rem (24px)
                '3xl': ['24px', '32px'],      // default: 1.875rem (30px)
                '4xl': ['28px', '36px'],      // default: 2.25rem (36px)
                '5xl': ['32px', '40px'],      // default: 3rem (48px)
                '6xl': ['36px', '44px'],      // default: 3.75rem (60px)
                '7xl': ['42px', '50px'],      // default: 4.5rem (72px)
              }
        },
    },

    plugins: [forms,require('@tailwindcss/typography')],
};
