const path = require("path");
const glob = require("glob");
const webpack = require("webpack");
const {VueLoaderPlugin} = require("vue-loader");
const {WebpackManifestPlugin} = require("webpack-manifest-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const {PurgeCSSPlugin} = require('purgecss-webpack-plugin');

const devMode = process.env.NODE_ENV !== "production";
const dirNix = path.join(__dirname).replaceAll(/\\/g, '/');

module.exports = {
    mode: devMode ? "development" : "production",

    entry: {
        common: [
            "./resources/js/common.js",
            "./resources/js/home1.js"
        ],
        login1: {
            import: "./resources/js/auth/login.js",
            dependOn: "vendors-vue",
        },
        register1: {
            import: "./resources/js/auth/register.js",
            dependOn: "vendors-vue",
        },
        forgot1: {
            import: "./resources/js/auth/forgot.js",
            dependOn: "vendors-vue",
        },
        new1: {
            import: "./resources/js/new-ad.js",
            dependOn: "vendors-vue",
        },
        edit1: {
            import: "./resources/js/edit-ad.js",
            dependOn: "vendors-vue",
        },
        show1: "./resources/js/show-ad1.js",
        search1: {
            import: "./resources/js/catalog/search.js",
            dependOn: "vendors-vue",
        },
        styles: "./resources/scss/styles-app.scss",
        "vendors-vue": ["vue", "@vuelidate/core", "@vuelidate/validators"],
        "vendors-bs5": [
            "bootstrap/js/dist/dropdown.js",
            "bootstrap/js/dist/modal.js"
        ],
    },

    output: {
        filename: "[name].[contenthash].js",
        path: path.resolve(__dirname, "./public/dist/"),
        clean: true,
    },

    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: "vue-loader",
            },
            {
                test: /\.css$/,
                use: ["vue-style-loader", "css-loader"],
            },
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    "css-loader",
                    "sass-loader"
                ],
            },
        ],
    },

    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: false,
            __VUE_PROD_DEVTOOLS__: false,
        }),
        new VueLoaderPlugin(),
        new MiniCssExtractPlugin({
            filename: "[name].[contenthash].css",
        }),
        devMode ? () => {
        } : new PurgeCSSPlugin({
            paths: glob.sync(`${dirNix}/resources/**/*`, {nodir: true}),
            safelist: [
                /^bg-[a-z]+$/,
                /modal-backdrop/,
                /carousel-(inner|item|control)/,
                /ratio-16x9/,
                /visually-hidden/,
            ]
        }),
        new WebpackManifestPlugin({
            basePath: "/dist/",
            publicPath: "/dist/",
            fileName: path.resolve(__dirname, "./public/mix-manifest.json"),
        }),
    ],
};
