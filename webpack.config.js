const path = require("path");
const webpack = require("webpack");
const { VueLoaderPlugin } = require("vue-loader");
const { WebpackManifestPlugin } = require("webpack-manifest-plugin");

module.exports = {
    mode: "production", // development | production

    entry: {
        "new-ad-details": "./resources/js/new-ad-details.js",
        "new-ad-location": "./resources/js/new-ad-location.js",
        "app-scripts": "./resources/js/app-scripts.js",
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
        ],
    },

    plugins: [
        new VueLoaderPlugin(),
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: false,
            __VUE_PROD_DEVTOOLS__: false,
        }),
        new WebpackManifestPlugin({
            basePath: "/dist/",
            publicPath: "/dist/",
            fileName: path.resolve(__dirname, "./public/mix-manifest.json"),
        }),
    ],
};
