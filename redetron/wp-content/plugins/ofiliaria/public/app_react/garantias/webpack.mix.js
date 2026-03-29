const mix = require('laravel-mix');

// Detectamos si es una compilación especial de producción
const isProdCustom = process.env.BUILD_TARGET === 'prod_deploy';

// Definimos nombres de archivos dinámicos
const jsName = isProdCustom ? 'main-script-produccion.js' : 'main-script.js';
const cssName = isProdCustom ? 'main-style-produccion.css' : 'main-style.css';

mix.options({
    processCssUrls: false,
    vue: false 
});

mix.react('src/main.jsx', `dist/${jsName}`)
   .sass('src/index.scss', `dist/${cssName}`)
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
                        require('path').resolve(__dirname, 'src') // Esto detecta la carpeta src donde sea que esté
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