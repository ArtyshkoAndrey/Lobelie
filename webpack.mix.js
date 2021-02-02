const mix = require('laravel-mix');
let productionSourceMaps = true;
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
  .js('resources/js/user/app.js', 'public/js')
  .sass('resources/sass/user/app.scss', 'public/css')
  .js('resources/js/admin/app.js', 'public/js/admin')
  .sass('resources/sass/admin/app.scss', 'public/css/admin')
  .sourceMaps(productionSourceMaps, 'source-map')

if (mix.inProduction()) {
  mix.version();
}

mix.browserSync('http://docu');
mix.disableNotifications();
