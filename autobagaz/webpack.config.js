const path = require('path');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');

module.exports = {
    entry: [
        './Sass/style.scss',
    ],
    output:
    {
        path: path.resolve(__dirname, 'wwwroot/build'),
        filename: './autobagaz.js',
    },
    optimization: {
        minimizer: [
            new OptimizeCSSAssetsPlugin({}),
        ],
    },
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    MiniCssExtractPlugin.loader,
                    'css-loader',
                    'sass-loader',
                ],
            },
        ],
    },
    plugins: [
        new CleanWebpackPlugin(),
        new MiniCssExtractPlugin({
            filename: './autobagaz.css',
        })
    ],
    devServer: {
        port: 8080,
        historyApiFallback: true,
    },
};