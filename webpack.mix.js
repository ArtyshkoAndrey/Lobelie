const mix = require('laravel-mix');
let productionSourceMaps = false;
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

mix.options({processCssUrls: false})

mix.js('resources/js/user/app.js', 'public/js')
  .sass('resources/sass/user/app.scss', 'public/css')

mix.js('resources/js/admin/app.js', 'public/js/admin')
  .sass('resources/sass/admin/app.scss', 'public/css/admin')
  .sourceMaps(productionSourceMaps, 'source-map')

if (mix.inProduction()) {
  mix.version();
}

mix.browserSync('http://lobelie');
mix.disableNotifications();

