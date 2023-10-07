import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import reactRefresh from '@vitejs/plugin-react-refresh';

import vue from'@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/admin.js'],
            refresh: true,
        }),

        vue({
            template: {
                transformAssetUrls: {
                    base : null,
                    includeAbsolute: false,
                }
            }
        }),
        [reactRefresh()],               
    ],
});
