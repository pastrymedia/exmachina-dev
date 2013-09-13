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

// Pretty Selects
jQuery(document).ready(function($){
  $(".pretty-select").selectBoxIt();
});

// Ui Slider
jQuery(document).ready(function($){
  $( "#slider" ).slider();
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

// Chosen Selects
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


// Select2
jQuery(document).ready(function($){
  $(".select-two").select2({
    minimumResultsForSearch: 10
  });
});

// Selectize
jQuery(document).ready(function($){
$('.selectize').selectize({
          create: true,
          sortField: 'text',
          dropdownParent: null
        });
});



// Uniform JS
jQuery(document).ready(function($){
  $(".uniform").uniform();
});

// Input spinner
jQuery( document ).ready( function ( $ ) {


  $( ".input_spinner" ).spinner( {
    spin : function ( event, ui ) {
      spinner_spin( event, ui, $( this ), 'parseint' );
    },
    stop : function () {
      spinner_stop( $( this ), 'parseint' );
    }
  } ).blur( function ( event ) {
      spinner_blur( event, $( this ), 'parseint' );
    } );

  $( ".input_spinner.decimal" ).spinner( {
    step : 0.01,
    spin : function ( event, ui ) {
      spinner_spin( event, ui, $( this ), 'parsefloat' );
    },
    stop : function () {
      spinner_stop( $( this ), 'parsefloat' );
    }
  } ).blur( function ( event ) {
      spinner_blur( event, $( this ), 'parsefloat' );
    } );

  function spinner_spin( event, ui, _this, type ) {
    var value, min, max;
    if ( type == "parseint" ) {
      value = parseInt( ui.value, 10 );
      min = parseInt( _this.attr( "aria-custom-min" ), 10 );
      max = parseInt( _this.attr( "aria-custom-max" ), 10 );
    } else {
      value = parseFloat( ui.value );
      min = parseFloat( _this.attr( "aria-custom-min" ) );
      max = parseFloat( _this.attr( "aria-custom-max" ) );
    }

    if ( _this.val() > max ) {
      return _this.val( max );
    } else if ( _this.val() < min ) {
      return _this.val( min );
    }
  }

  function spinner_stop( _this, type ) {
    var val, min, max;
    if ( type == "parseint" ) {
      val = parseInt( _this.val(), 10 );
      min = parseInt( _this.attr( "aria-custom-min" ), 10 );
      max = parseInt( _this.attr( "aria-custom-max" ), 10 );
    } else {
      val = parseFloat( _this.val() );
      min = parseFloat( _this.attr( "aria-custom-min" ) );
      max = parseFloat( _this.attr( "aria-custom-max" ) );
    }

    if ( val > max ) {
      _this.val(function () {
        return max;
      } ).attr( 'aria-valuenow', function () {
          return max;
        } );
    } else if ( val < min ) {
      _this.val(function () {
        return min;
      } ).attr( 'aria-valuenow', function () {
          return min;
        } );
    }

    if ( _this.parents( ".option_input" ).hasClass( "typography" ) ) {
      _this.font_preview();
    }
  }

  function spinner_blur( event, _this, type ) {
    var val, min, max;
    if ( type == "parseint" ) {
      val = parseInt( _this.val(), 10 );
      min = parseInt( _this.attr( "aria-custom-min" ), 10 );
      max = parseInt( _this.attr( "aria-custom-max" ), 10 );
    } else {
      val = parseFloat( _this.val() );
      min = parseFloat( _this.attr( "aria-custom-min" ) );
      max = parseFloat( _this.attr( "aria-custom-max" ) );
    }

    if ( val > max ) {
      return _this.val(function () {
        return max;
      } ).attr( 'aria-valuenow', function () {
          return max;
        } );
    } else if ( val < min ) {
      return _this.val(function () {
        return min;
      } ).attr( 'aria-valuenow', function () {
          return min;
        } );
    }
  }

  $( ".typography-handle" ).change( function () {
    $( this ).font_preview();
  } );


} );




