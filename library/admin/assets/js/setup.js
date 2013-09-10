/**
 * Admin Interface JavaScript
 *
 * All JavaScript logic for the theme options admin interface.
 * @since 4.8.0
 *
 */

(function ($) {

  woothemesAdmin = {










/**
 * setup_custom_typography()
 *
 * @since 4.8.0
 */

 	setup_custom_typography: function () {
	 	$( 'select.woo-typography-unit' ).change( function(){
			var val = $( this ).val();
			var parent = $( this ).parent();
			var name = parent.find( '.woo-typography-size-px' ).attr( 'name' );
			if( name == '' ) { var name = parent.find( '.woo-typography-size-em' ).attr( 'name' ); }

			if( val == 'px' ) {
				var name = parent.find( '.woo-typography-size-em' ).attr( 'name' );
				parent.find( '.woo-typography-size-em' ).hide().removeAttr( 'name' );
				parent.find( '.woo-typography-size-px' ).show().attr( 'name', name );
			}
			else if( val == 'em' ) {
				var name = parent.find( '.woo-typography-size-px' ).attr( 'name' );
				parent.find( '.woo-typography-size-px' ).hide().removeAttr( 'name' );
				parent.find( '.woo-typography-size-em' ).show().attr( 'name', name );
			}

		});
 	}, // End setup_custom_typography()

 /**
 * setup_colourpickers()
 *
 * @since 4.8.0
 */

 	setup_colourpickers: function () {
 		if ( jQuery().ColorPicker && $( '.section-typography, .section-border, .section-color' ).length ) {
 			$( '.section-typography, .section-border, .section-color' ).each( function () {

 				var option_id = $( this ).find( '.woo-color' ).attr( 'id' );
				var color = $( this ).find( '.woo-color' ).val();
				var picker_id = option_id += '_picker';

 				if ( $( this ).hasClass( 'section-typography' ) || $( this ).hasClass( 'section-border' ) ) {
					option_id += '_color';
				}

	 			$( '#' + picker_id ).children( 'div' ).css( 'backgroundColor', color );
				$( '#' + picker_id ).ColorPicker({
					color: color,
					onShow: function ( colpkr ) {
						jQuery( colpkr ).fadeIn( 200 );
						return false;
					},
					onHide: function ( colpkr ) {
						jQuery( colpkr ).fadeOut( 200 );
						return false;
					},
					onChange: function ( hsb, hex, rgb ) {
						$( '#' + picker_id ).children( 'div' ).css( 'backgroundColor', '#' + hex );
						$( '#' + picker_id ).next( 'input' ).attr( 'value', '#' + hex );

					}
				});
 			});
 		}
 	}, // End setup_colourpickers()








  }; // End woothemesAdminInterface Object // Don't remove this, or the sky will fall on your head.

/**
 * Execute the above methods in the woothemesAdminInterface object.
 *
 * @since 4.8.0
 */
	$(document).ready(function () {

		woothemesAdmin.setup_custom_typography();
		woothemesAdmin.setup_colourpickers();


	});

})(jQuery);