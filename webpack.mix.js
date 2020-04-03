let mix = require('laravel-mix')

mix
  .setPublicPath('dist')
  .js('resources/js/tool.js', 'js')
  .sass('resources/sass/tool.scss', 'css')

mix
  .setPublicPath('dist')
  .js('resources/js/card.js', 'js')
  .sass('resources/sass/card.scss', 'css')

mix
  .setPublicPath('dist')
  .js('resources/js/field.js', 'js')
  .sass('resources/sass/field.scss', 'css')

mix
  .setPublicPath('dist')
  .js('resources/js/resource-tool.js', 'js')
  .sass('resources/sass/resource-tool.scss', 'css')