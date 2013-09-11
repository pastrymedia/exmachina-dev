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

jQuery(document).ready(function($) {

  // Prepends close button to theme settings notices.
  $( ".settings-error" ).attr( "data-uk-alert", '' ).prepend( "<button class='uk-alert-close uk-close'>" );

});

jQuery(document).ready(function($){
  $(".pretty-select").selectBoxIt();
});

jQuery(document).ready(function($){
  $('.colourpicker').minicolors({
    change: function(hex, opacity) {
        $(this).font_preview();
    }
  });
});

jQuery(document).ready(function($){
  var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
});

jQuery(document).ready(function($){
  $(".uniform").uniform();
});




