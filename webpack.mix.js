const mix = require('laravel-mix');

// Copy Dropzone assets from node_modules to public folder
mix.copy('node_modules/dropzone/dist/dropzone.css', 'public/dropzone/dropzone.css')
   .copy('node_modules/dropzone/dist/dropzone.min.js', 'public/dropzone/dropzone.min.js');
