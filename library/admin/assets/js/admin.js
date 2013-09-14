/**
 * ExMachina WordPress Theme Engine Framework
 * <[title]>
 *
 * <[description]>
 *
 * @package ExMachina
 * @subpackage <[subpackage]>
 * @author <[author]> <[email]>
 * @copyright Copyright(c) 2012-2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link <[link]>
 */

// Settings Error Close Button
jQuery(document).ready(function($) {

  // Prepends close button to theme settings notices.
  $( ".settings-error" ).attr( "data-uk-alert", '' ).prepend( "<button class='uk-alert-close uk-close'>" );

});

// WP Colorpicker
// http://www.paulund.co.uk/adding-a-new-color-picker-with-wordpress-3-5
jQuery(document).ready(function($){
    $('.wp-color-picker-field').wpColorPicker();
});

// Minicolor picker
jQuery(document).ready(function($){
  $('.colourpicker').minicolors({
    change: function(hex, opacity) {
        $(this).font_preview();
    }
  });
});

// Select2
jQuery(document).ready(function($){
  $(".select-two").select2({
    minimumResultsForSearch: 10
  });
});











