const mix = require('laravel-mix');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery', 'jquery']
});

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
    .sass('resources/sass/app.scss', 'public/css');

mix.styles([
        'public/intranet/css/pages/login-register-lock.css',
        'public/intranet/css/style.css'
    ], 'public/css/login.css')
    .scripts([
        'public/intranet/node_modules/popper/popper.min.js'
    ], 'public/js/login.js');
    

mix.styles([
    'public/intranet/css/pages/login-register-lock.css',
    'public/intranet/css/style.min.css'
    ], 'public/css/login.css');
    
mix.styles([
    'public/intranet/css/style.min.css',
    'public/intranet/css/pages/dashboard1.css',
    'public/intranet/css/pages/floating-label.css',
    'public/intranet/node_modules/morrisjs/morris.css'
], 'public/css/admin.css')
.scripts([
    'public/intranet/node_modules/jquery/jquery-3.2.1.min.js',
    'public/intranet/node_modules/popper/popper.min.js',
    'public/intranet/js/perfect-scrollbar.jquery.min.js',
    'public/intranet/js/waves.js',
    'public/intranet/js/sidebarmenu.js',
    'public/intranet/js/custom.js',
    'public/intranet/node_modules/jquery-sparkline/jquery.sparkline.min.js',
    'public/intranet/node_modules/raphael/raphael-min.js',
    'public/intranet/node_modules/morrisjs/morris.min.js',
    'public/intranet/js/dashboard1.js',
    'public/intranet/js/sweetalerts2.all.js'
], 'public/js/admin.js').version();