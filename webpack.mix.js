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
    .sass('resources/sass/app.scss', 'public/css')

//////////Stisla Assets//////////
const stisla = 'public/assets/stisla/';
mix.js('./resources/js/app-stisla.js', stisla + 'js/app.js')
    .sass('./resources/sass/stisla/style.scss', stisla + 'css/style.css')
    .sass('./resources/sass/stisla/components.scss', stisla + 'css/components.css');

//////////Front Assets//////////
const front = 'public/assets/front/';
mix.js('./resources/js/front.js', front+ 'js/app.js')
    .sass('./resources/sass/front/style.scss', front + 'css/style.css');
    
//////////Modules//////////
const modules = 'public/assets/modules/';
//print js
mix.copy('node_modules/print-js/dist/print.js', modules);

//summernote
mix.copy([
    'node_modules/summernote/dist/summernote-bs4.min.css',
    'node_modules/summernote/dist/summernote-bs4.min.js',
], modules + 'summernote');
mix.copyDirectory('node_modules/summernote/dist/font', modules + 'summernote/font');

//daterangepicker
mix.copy([
    'node_modules/bootstrap-daterangepicker/daterangepicker.css',
    'node_modules/bootstrap-daterangepicker/daterangepicker.js',
    'node_modules/bootstrap-daterangepicker/moment.min.js',
], modules + 'bootstrap-daterangepicker');

