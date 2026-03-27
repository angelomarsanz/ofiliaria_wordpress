const mix = require('laravel-mix');

// Desactivamos Vue para evitar conflictos
mix.options({
    processCssUrls: false,
    vue: false 
});

mix.react('src/main.jsx', 'dist/main-script.js')
   .sass('src/index.scss', 'dist/main-style.css')
   .setPublicPath('dist')
   .webpackConfig({
       module: {
           rules: [
               {
                   test: /\.js$|jsx/,
                   include: [
                       /node_modules\/@mui/,
                       /node_modules\/@emotion/,
                       /node_modules\/react-i18next/,
                       // Adaptamos la ruta al entorno actual de WordPress
                       /public\/app_react\/garantias\/src/ 
                   ],
                   use: [{
                       loader: 'babel-loader',
                       options: {
                           presets: [
                               ['@babel/preset-env', {
                                   targets: "defaults",
                                   forceAllTransforms: true
                               }],
                               ['@babel/preset-react', {
                                   "runtime": "automatic"
                               }]
                           ],
                           plugins: [
                               '@babel/plugin-transform-optional-chaining',
                               '@babel/plugin-transform-nullish-coalescing-operator',
                               '@babel/plugin-transform-class-properties',
                               '@babel/plugin-transform-logical-assignment-operators'
                           ]
                       }
                   }]
               }
           ]
       },
       // Mantenemos el poll para VestaCP
       watchOptions: {
           poll: 1000,
           ignored: /node_modules/
       }
   });