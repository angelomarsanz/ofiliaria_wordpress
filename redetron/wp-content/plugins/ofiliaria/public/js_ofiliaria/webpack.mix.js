const mix = require('laravel-mix');

mix.options({
    processCssUrls: false,
    vue: false,
    terser: {
      extractComments: false, // Esto evita que se creen archivos .LICENSE.txt innecesarios
    }
});

mix.js('src/main.js', 'dist/js_ofiliaria-main-script.js')
   .styles('src/index.css', 'dist/js_ofiliaria-main-style.css')
   .setPublicPath('dist');

if (!mix.inProduction()) {
    mix.webpackConfig({
        watchOptions: {
            poll: 1000,
            ignored: /node_modules/
        }
    });
}