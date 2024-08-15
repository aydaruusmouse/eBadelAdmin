const mix = require('laravel-mix');
const path = require('path');

mix.js('resources/js/template/src/index.js', 'public/js')
   .react()
   // Add this line for CSS
   .webpackConfig({
       resolve: {
           alias: {
               '@': path.resolve('resources/js/template/src')
           }
       }
   });
