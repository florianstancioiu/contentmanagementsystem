const mix = require('laravel-mix');

mix
    .js('resources/js/admin.js', 'public/js')
    .js('resources/js/client.js', 'public/js')
    .sass('resources/scss/client.scss', 'public/css')
    .sass('resources/scss/admin.scss', 'public/css');