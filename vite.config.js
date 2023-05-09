import {defineConfig, splitVendorChunkPlugin} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/sass/styles-map.scss',

                'resources/js/app.js',
                'resources/js/catalog/home.js',
                'resources/js/catalog/show-item.js',
                'resources/js/auth/index.js',
                'resources/js/profile/index.js',
                'resources/js/catalog/search.js',
                'resources/js/member/member_index.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        // splitVendorChunkPlugin,
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, './resources'),
        },
    },

    build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    // 'vendor-mapbox': ['mapbox-gl'],
                },
            },
        },
    },
});
