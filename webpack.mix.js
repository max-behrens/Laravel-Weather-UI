// webpack.mix.js
const mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'public/css'); // This compiles SCSS to CSS

mix.js('resources/js/app.js', 'public/js')
   .vue()
   .babelConfig({
      presets: ['@babel/preset-env'],
  });