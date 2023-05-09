import {defineConfig, splitVendorChunkPlugin} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import glob from 'glob';
import path from 'node:path';

const input = [
    'resources/sass/app.scss',
    'resources/js/common.js',
];
glob.sync('resources/js/**/*.js').map(file => {
    if (file.match(/resources\/js\/[a-z]+\//)) {
        input.push(file);
    }
});

export default defineConfig({
    plugins: [
        laravel({
            input,
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
        splitVendorChunkPlugin,
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
            '@': path.resolve(__dirname, './resources'),
        },
    },

    // build: {
    //     rollupOptions: {
    //         output: {
    //             manualChunks: {
    //                 'vendor-map': ['leaflet'],
    //                 'vendor-vue': ['vue', '@vuelidate/core', '@vuelidate/validators', 'vue-currency-input', 'axios'],
    //             },
    //         },
    //     },
    // },
});
