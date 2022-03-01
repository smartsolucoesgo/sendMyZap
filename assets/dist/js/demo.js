(function ($) {
    'use strict' 

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1)
      }
    
      function createSkinBlock(colors, callback, noneSelected) {
        var $block = $('<select />', {
          class: noneSelected ? 'custom-select mb-3 border-0' : 'custom-select mb-3 text-light border-0 ' + colors[0].replace(/accent-|navbar-/, 'bg-')
        })
    
        if (noneSelected) {
          var $default = $('<option />', {
            text: 'None Selected'
          })
          if (callback) {
            $default.on('click', callback)
          }
    
          $block.append($default)
        }
    
        colors.forEach(function (color) {
          var $color = $('<option />', {
            class: (typeof color === 'object' ? color.join(' ') : color).replace('navbar-', 'bg-').replace('accent-', 'bg-'),
            text: capitalizeFirstLetter((typeof color === 'object' ? color.join(' ') : color).replace(/navbar-|accent-|bg-/, '').replace('-', ' '))
          })
    
          $block.append($color)
    
          $color.data('color', color)
    
          if (callback) {
            $color.on('click', callback)
          }
        })
    
        return $block
      }


      console.log(dark_mode)
})