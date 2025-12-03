import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/mainpage.js',
                'public/static/css/app.min.css'
            ],
            refresh: true,
        }),
    ],
});
