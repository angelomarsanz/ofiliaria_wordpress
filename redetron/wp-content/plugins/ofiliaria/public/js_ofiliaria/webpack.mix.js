const mix = require('laravel-mix');

mix.options({
    processCssUrls: false,
    vue: false // Esto debería evitar que pida cosas de Vue
});

// Cambiamos .sass por .styles para archivos CSS puros
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