var webpack = require('webpack');
var path = require('path');
var glob = require('glob');
var glob = require('glob-all');

var ExtractTextPlugin = require("extract-text-webpack-plugin");
var PurifyCSSPlugin = require('purifycss-webpack');
var CleanWebpackPlugin = require('clean-webpack-plugin');
var autoprefixer = require('autoprefixer');
var CopyWebpackPlugin = require('copy-webpack-plugin');

var InProduction = (process.env.NODE_ENV === 'production');

module.exports = {
    entry: {

        autobagaz: [
                './src/main.js',
                './src/common.blocks/tabs/tabs.js',
                './src/common.blocks/rewiew/rewiew__answer.js',
                './src/common.blocks/modal-call/modal-call.js',
                './src/common.blocks/gallery/gallery.js',
          './src/common.blocks/header/top-header.js',
                './src/library.blocks/img/img.js',
                './src/style.scss'

        ],
        //vendor: ['jquery']

    },

    output: {
        path: path.resolve(__dirname, 'build'),
        filename: '[name].js'

    },

    module: {

        rules: [

            {
                test: /\.s[ac]ss$/,
                use: ExtractTextPlugin.extract(
                    {
                        fallback: 'style-loader',
                        use: [
                            {
                                loader: 'css-loader',
                                options: {
                                    minimize: true
                                }
                            },
                            {
                                loader: 'postcss-loader'
                            },
                            {
                                loader: 'sass-loader'
                            }]
                    })
            },

            {
                test: /\.css$/,
                use: ['css-loader']
            },

            {

                test: /\.(svg|eot|ttf|woff|woff2)$/,
                loader: 'file-loader',
                options: {
                    name: '/fonts/[name].[ext]'
                }
            },

            {

                test: /\.(png|JPE?G|jpe?g|gif)$/,
                loaders: [
                    {

                        loader: 'file-loader',
                        options: {
                            name: '[path]/[name].[ext]',
                        },
                    },

                    'img-loader'

                ]

            },

            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader"
            },
        ]
    },

    plugins: [

        new ExtractTextPlugin('[name].css'),

        /*new PurifyCSSPlugin({
            // Give paths to parse for rules. These should be absolute!
            paths: glob.sync([

                path.join(__dirname, '*.html'),
                path.join(__dirname, '*.php'),

        ]),
            minimize: InProduction

        }),*/

        // new CopyWebpackPlugin(
        //     [
        //         {from: '/img', to: 'img' }
        //     ]
        // ),

        new CleanWebpackPlugin(['build'], {
            root: __dirname,
            verbose: true,
            dry: false
        }),

        new webpack.LoaderOptionsPlugin({

            minimize: InProduction
        })

    ]

};

if (InProduction) {
    module.exports.plugins.push(
        new webpack.optimize.UglifyJsPlugin()
    );
}
