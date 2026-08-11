import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/styles.css',
                'resources/css/utility.css',
                'resources/js/app.js',
                'resources/js/common.js',
            ],
            refresh: true,
        }),
    ],
});
