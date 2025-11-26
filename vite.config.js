import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            // FIX: Tambahkan style2.css dan dashboard.js ke array input
            input: [
                'resources/css/app.css',          // CSS default Laravel
                'resources/css/style2.css',       // <-- CSS DASHBOARD ANDA
                'resources/js/app.js',            // JS default Laravel
                'resources/js/dashboard.js',      // <-- JS DASHBOARD ANDA
            ],
            refresh: true,
        }),
        tailwindcss(), // Biarkan plugin tailwindcss tetap ada
    ],
});