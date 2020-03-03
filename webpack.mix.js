let mix = require('laravel-mix');

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

/*mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');*/

mix.styles([
   'resources/plantilla/css/font-awesome.css',
   'resources/plantilla/css/ionicons.css',
   'resources/plantilla/css/AdminLTE.css',
   'resources/plantilla/css/_all-skins.css'
], 'public/css/plantilla.css')
.scripts([
   'resources/plantilla/js/jquery.js',
   'resources/plantilla/js/bootstrap.js',
   'resources/plantilla/js/jquery.slimscroll.js',
   'resources/plantilla/js/fastclick.js',
   'resources/plantilla/js/sweetalert2.all.min.js',
   'resources/plantilla/js/adminlte.js',
   'resources/plantilla/js/demo.js',
], 'public/js/plantilla.js')
.js(['resources/assets/js/app.js'], 'public/js/app.js');