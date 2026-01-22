import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    presets: [
        require('./vendor/wireui/wireui/tailwind.config.js')
    ],
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/wireui/wireui/src/*.php',
        './vendor/wireui/wireui/ts/**/*.ts',
        './vendor/wireui/wireui/src/WireUi/**/*.php',
        './vendor/wireui/wireui/src/Components/**/*.php',
    ],

    theme: {
        extend: {
            colors: {
                'brand': {
                    'primary': '#b91c1c', // Tu rojo corporativo
                    'dark': '#1f2937',    // Tu gris oscuro 600
                    'soft': '#f6f7f9',    // Tu 50 para fondos claros
                },
                // O puedes mantener tu estructura pero dándole nombres lógicos
                'custom': {
                    'dark-bg': '#1f2937',
                    'dark-header': '#374151',
                    'red': '#b91c1c',
                }
            },
        },
    },
    plugins: [forms, typography],
};
