const mix = require('laravel-mix')

// mix.webpackConfig({
//     stats: {
//         children: true,
//     },
// });

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

mix
// .js([
//     'resources/site/js/main.js',
//     // 'resources/site/js/jquery.js'
// ], 'public/js/app.js')
    .js('resources/js/app.js', 'public/js')

// .js([
//     'resources/site/js/main.js',
//     // 'resources/site/js/jquery.js'
//     'resources/js/app.js'
// ], 'public/js/app.js')
// .js('resources/js/app.js', 'public/js')
// .autoload({
//     jquery: ['$', 'window.jQuery']
// })
.vue()
    // .css('resources/css/style.css', 'public/css/app.css', [
    // stats.children: true
    // ])
    // .postCss('resources/css/style.css', 'public/css', [
    //     //
    // ])
    // .copy('resources/site', 'public/site')
    .copy('resources/apiAllAutoparts', 'public/apiAllAutoparts')
    // .sass('resources/css/_pagination.scss', 'public/css/app.css', [])
    // .postCss('resources/css/_pagination.scss', 'public/css/app.css', [])
    // .postCss('resources/scss/bootstrap.css', 'public/css/app.css', [])
    .postCss('resources/css/app.css', 'public/css', [])
    // .postCss('storage/app/public/css/bootstrap.css', 'public/css/app.css', [])
    .postCss('storage/app/public/css/font-awesome.css', 'public/css/app.css', [])
    // .postCss('storage/app/public/css/ionicons.min.css', 'public/css/app.css', [])
    // .postCss('storage/app/public/css/style.css', 'public/css/app.css', [])
    // .css('storage/app/public/css/style.css', 'public/css/app.css', [])

// <link rel="stylesheet" href="{{ asset('storage/css/bootstrap.css') }}">
// <link rel="stylesheet" href="{{ asset('storage/css/font-awesome.css') }}">
// <link rel="stylesheet" href="{{ asset('storage/css/ionicons.min.css') }}">
// {{-- <link rel="stylesheet" href="{{ asset('storage/css/slick.css') }}"> --}}
// {{-- <link rel="stylesheet" href="{{ asset('storage/css/slick-theme.css') }}"> --}}
// {{-- <link rel="stylesheet" href="{{ asset('storage/css/owl.carousel.min.css') }}"> --}}
// <link rel="stylesheet" href="{{ asset('storage/css/style.css') }}">