const path = require("path");
const webpack = require("webpack");
const { VueLoaderPlugin } = require("vue-loader");

module.exports = {
    mode: "production", // development | production

    entry: {
        "new-ad-details": "./resources/js/new-ad-details.js",
        "new-ad-location": "./resources/js/new-ad-location.js",
    },

    output: {
        filename: "[name].bundle.js",
        path: path.resolve(__dirname, "./public/dist"),
        clean: true,
    },

    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: "vue-loader",
            },
        ],
    },

    plugins: [
        new VueLoaderPlugin(),
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: false,
            __VUE_PROD_DEVTOOLS__: false,
        }),
    ],
};
