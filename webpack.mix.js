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
    // .postCss('resources/css/app.css', 'public/css', [ // ori
    .sass('resources/scss/common.scss', 'public/css/main', [])
    .sass('resources/scss/font.scss', 'public/css/main', [])
    .sass('resources/scss/header.scss', 'public/css/main', [])
    .sass('resources/scss/layout.scss', 'public/css/main', [])
    .sass('resources/scss/channel/create.scss', 'public/css/channel', [])
    ;