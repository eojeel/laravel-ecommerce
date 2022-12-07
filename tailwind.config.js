const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            keyframes: {
                'fade-in-down': {
                    'from': {
                        opacity: '0',
                        transform: 'translateY(-0.75rem)'
                    },
                    'to': {
                        opacity: '1',
                        transform: 'translateY(0rem)'
                    }
                },
                animation: {
                    'fade-in-down': "fade-in-down 0.2s ease-in-out both",
                }
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/aspect-ratio')
    ],
};
