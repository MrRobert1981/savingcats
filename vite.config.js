import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
   /*  server: {
        host: '0.0.0.0', // Permite conexiones externas (LAN)
        port: 5173,
        strictPort: true,
        cors: true, // Habilita CORS
    }, */
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
