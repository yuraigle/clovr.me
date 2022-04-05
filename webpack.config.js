const path = require("path");
const webpack = require("webpack");
const { VueLoaderPlugin } = require("vue-loader");
const { WebpackManifestPlugin } = require("webpack-manifest-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    mode: "development",

    entry: {
        "show0": "./resources/js/show-ad.js",
        "edit0": "./resources/js/edit-ad.js",
        "new0": "./resources/js/new-ad.js",
        "auth-login-box": "./resources/js/auth-login-box.js",
        "auth-register-box": "./resources/js/auth-register-box.js",
        "auth-forgot-box": "./resources/js/auth-forgot-box.js",
        "app-scripts": "./resources/js/app-scripts.js",
        "app-styles": "./resources/js/app-styles.js",
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
                test: /\.s[ac]ss$/i,
                use: [MiniCssExtractPlugin.loader, "css-loader", "sass-loader"],
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
        new MiniCssExtractPlugin({
            filename: "[name].[contenthash].css",
        }),
    ],
};
