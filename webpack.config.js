const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
let path = require('path');

// change these variables to fit your project
const jsPath = './assets/js';
const cssPath = './assets/scss';
const outputPath = 'dist';
const localDomain = 'https://ovh.local';
const entryPoints = {
    // 'app' is the output name, people commonly use 'bundle'
    // you can have more than 1 entry point
    'app': jsPath + '/app.js',
    'style': cssPath + '/style.scss'
};

module.exports = {
    entry: entryPoints,
    output: {
        path: path.resolve(__dirname, outputPath),
        filename: 'js/[name].js'
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'css/[name].css',
        }),

        // Uncomment this if you want to use CSS Live reload
        new BrowserSyncPlugin({
            proxy: localDomain,
            files: 'dist/css/*.css',
            injectCss: true,
        }, { reload: false, }),
    ],
    module: {
        rules: [
            {
                test: /\.s?[c]ss$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ],
            },
            {
                test: /\.sass$/i,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    {
                        loader: 'sass-loader',
                        options: {
                            sassOptions: {indentedSyntax: true},
                        },
                    },
                ],
            },
            {
                test: /\.(jpg|jpeg|png|gif|svg)$/i,
                type: 'asset/resource',
                generator: {
                    filename: 'images/[hash][ext][query]'
                }
            },
            {
                test: /\.(eot|woff|woff2|ttf)$/,
                type: 'asset/resource',
                generator: {
                    filename: 'fonts/[hash][ext][query]'
                }
            },
        ]
    },
};