const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
        .postCss('resources/css/app.css', 'public/css', [
        //
    ])

    //.sass('resources/sass/app.scss', 'public/css')
    .version();
mix.js('resources/js/app.js', 'public/js')
    .babelConfig({
        presets: ['@babel/preset-env'],
    })
    .sass('resources/sass/app.scss', 'public/css');


mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env']
                    }
                }
            }
        ]
    }
});
