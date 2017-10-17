var path = require('path');
var webpack = require('webpack');
var glob = require('glob');
var  ExtractTextPlugin = require('extract-text-webpack-plugin');
var PurifyCSSPlugin = require('purifycss-webpack');
var CleanWebpackPlugin = require('clean-webpack-plugin');

var inProduction = (process.env.NODE_ENV === 'production');


var config = {
    // context: path.resolve(__dirname),

   // devtool: 'source-map',

    entry: [
        // vendor: ['jquery'],
      //  './js/main.js',
        './modules/style.scss'
    ],
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
                        use: [ 'css-loader', 'sass-loader']
                    })
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: "babel-loader"
            },
            // {
            //     test: /\.(png|jpg|gif|svg|eot|ttf|woff|woff2)$/,
            //     loader: 'url-loader',
            //     options:
            //         {
            //             limit: 500
            //         }
            // }

            {
                test: /\.(eot|svg|ttf|woff|woff2)$/,
                loader: 'file-loader',
            },
            {
                test: /\.(png|je?pg|gif)$/,

                loaders: [
                    {
                        loader: 'file-loader',
                        options:
                            {
                                name: '../[path][name].[ext]'
                            }
                    },

                    'img-loader'
                ]


                
            }
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        }),
        new ExtractTextPlugin(
        {
            filename: '[name].css',
            allChunks: true
        }),

      /*  new PurifyCSSPlugin({
            // Give paths to parse for rules. These should be absolute!
            paths: glob.sync(path.join(__dirname, 'index.html')),
            minimize: inProduction
        }),*/
        new CleanWebpackPlugin(['build'], {
            root: __dirname,
            verbose: true,
            dry: false
        }),

        new webpack.LoaderOptionsPlugin({
            minimize: inProduction
        })
    ]

};

module.exports = config;

if (inProduction)
{
    module.exports.plugins.push(
        new webpack.optimize.UglifyJsPlugin()
    );
}