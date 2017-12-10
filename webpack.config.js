var webpack = require('webpack');
var path = require('path');
var glob = require('glob');
var glob = require('glob-all');

var ExtractTextPlugin = require("extract-text-webpack-plugin");
var PurifyCSSPlugin = require('purifycss-webpack');
var CleanWebpackPlugin = require('clean-webpack-plugin');
var autoprefixer = require('autoprefixer');

var InProduction = (process.env.NODE_ENV === 'production');

module.exports = {
    entry: {

        autobagaz: [
                './js/main.js',
                './modules/style.scss'

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
                                    /* minimize: false || { /* CSSNano options /}*/
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

                test: /\.(png|jpe?g|gif)$/,
                loaders: [
                    {

                        loader: 'file-loader',
                        options: {
                            name: 'images/[name].[ext]'

                        }
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