const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/settings/kanban_behaviour.js', 'public/js/settings')
   .js('resources/js/header/header_behaviour.js', 'public/js/header')
    .sass('resources/sass/settings/kanban_style.scss', 'public/css/settings')
    .sass('resources/sass/header_style.scss', 'public/css')
    .sass('resources/sass/app.scss', 'public/css');
