<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * <FUCTION NAME>
 *
 * <FILENAME.PHP>
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <DESCRIPTION GOES HERE>
 *
 * @package ExMachina
 * @subpackage <SUBPACKAGE>
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

class ExMachina_Demo_Metabox {

  /**
   * Metabox Constructor
   *
   * @since 0.2.0
   */
  function __construct() {

    add_filter( 'exmachina_theme_settings_defaults', array( $this, 'setting_defaults' ) );
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitization' ) );

    add_action( 'exmachina_theme_settings_help', array( $this, 'help_tabs' ) );

    /* Create the demo meta box on the 'exmachina_theme_settings_metaboxes' hook. */
    add_action( 'exmachina_theme_settings_metaboxes', array( $this, 'register_metabox' ) );

  } // end function __construct()

  /**
   * Help Tab Content
   * @return [type] [description]
   */
  function help_tabs() {

    $screen = get_current_screen();

    $screen->add_help_tab( array(
      'id'      => 'demo-help',
      'title'   => 'Demo Help',
      'content' => '<p>Demo help content goes here.</p>',
    ) );

  } // end function help_tabs()

  /**
   * Defaults Filter
   * @param  [type] $defaults [description]
   * @return [type]           [description]
   */
  function setting_defaults( $defaults ) {

    $defaults['demo_one'] = __( 'This is the demo one default.', 'exmachina' );
    $defaults['demo_two'] = __( 'This is the demo two default.', 'exmachina' );
    $defaults['demo_three'] = __( 'This is the demo three default.', 'exmachina' );
    $defaults['demo_four'] = __( 'This is the demo four default.', 'exmachina' );

    return $defaults;
  } // end function setting_defaults()

  /**
   * Sanitization Filter
   * @return [type] [description]
   */
  function sanitization() {

    exmachina_add_option_filter( 'safe_html', EXMACHINA_SETTINGS_FIELD,
      array(
        'demo_one',
        'demo_two',
        'demo_three',
        'demo_four',
    ) );
  } // end function sanitization()

  /**
   * Register Metabox
   * @param  [type] $_exmachina_admin_theme_settings [description]
   * @return [type]                                  [description]
   */
  function register_metabox( $_exmachina_admin_theme_settings ) {

    add_meta_box('demo_metabox', 'Demo Metabox', array( $this, 'display_metabox' ), $_exmachina_admin_theme_settings, 'normal', 'high');

  } // end function register_metabox()

  /**
   * Display Metabox
   * @return [type] [description]
   */
  function display_metabox() {
    ?>
    <p>
      <label for="<?php echo EXMACHINA_SETTINGS_FIELD; ?>[demo_one]"><?php _e( 'Demo One:', 'exmachina' ); ?></label><br />
      <input type="text" name="<?php echo EXMACHINA_SETTINGS_FIELD; ?>[demo_one]" id="<?php echo EXMACHINA_SETTINGS_FIELD; ?>[demo_one]" value="<?php echo esc_attr( exmachina_get_option('demo_one', EXMACHINA_SETTINGS_FIELD) ); ?>" size="50" />
    </p>

    <p>
      <label for="<?php echo EXMACHINA_SETTINGS_FIELD; ?>[demo_two]"><?php _e( 'Demo Two:', 'exmachina' ); ?></label><br />
      <input type="text" name="<?php echo EXMACHINA_SETTINGS_FIELD; ?>[demo_two]" id="<?php echo EXMACHINA_SETTINGS_FIELD; ?>[demo_two]" value="<?php echo esc_attr( exmachina_get_option('demo_two', EXMACHINA_SETTINGS_FIELD) ); ?>" size="50" />
    </p>

    <p>
      <label for="<?php echo exmachina_get_field_id( 'demo_three' ); ?>"><?php _e( 'Demo Three:', 'exmachina' ); ?></label><br />
      <input type="text" name="<?php echo exmachina_get_field_name( 'demo_three' ); ?>" id="<?php echo exmachina_get_field_id( 'demo_three' ); ?>" value="<?php echo esc_attr( exmachina_get_field_value( 'demo_three' ) ); ?>" size="50" />
    </p>
    <?php
  } // end function display_metabox()

} // end class ExMachina_Demo_Metabox

new ExMachina_Demo_Metabox;

