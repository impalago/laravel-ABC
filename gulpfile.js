var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.scripts([
        '/jquery/dist/jquery.min.js',
        '/bootstrap/dist/js/bootstrap.min.js',
        '/bootstrap-material/dist/js/material.min.js',
        '/masonry-layout/dist/masonry.pkgd.js',
        '/jgrowl/jquery.jgrowl.min.js',
        '/jquery-confirm2/dist/jquery-confirm.min.js'],
        'public/js/dependencies.js', 'node_modules')

        .scriptsIn("resources/js/", 'public/js/app.js')

        .styles([
            "/bootstrap/dist/css/bootstrap.min.css",
            "/bootstrap-material/dist/css/material.min.css",
            "/jgrowl/jquery.jgrowl.min.css",
            "/jquery-confirm2/dist/jquery-confirm.min.css"
        ], 'public/css/dependencies.css', 'node_modules')
        .styles([
            "/style.css",
            "/ytb.css"
        ], 'public/css/style.css', 'resources/css');
});