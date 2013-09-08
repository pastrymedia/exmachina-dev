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
 * @package     ExMachina
 * @subpackage  Admin Functions
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin functions
###############################################################################

/* Add the admin setup function to the 'admin_menu' hook. */
add_action( 'exmachina_setup', 'exmachina_admin_setup' );

/**
 * Admin Setup Function
 *
 * Sets up the adminstration functionality for the framework and themes.
 *
 * @since  0.3.0
 */
function exmachina_admin_setup() {

  /* Adds custom icons to the admin menu. */
  add_action( 'admin_head', 'exmachina_custom_admin_icons' );

  /* Registers admin stylesheets and javascripts for the framework. */
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_register_styles', 1 );
  add_action( 'admin_enqueue_scripts', 'exmachina_admin_register_scripts', 1 );

} // end function exmachina_admin_setup()

/**
 * Custom Admin Icons
 *
 * Adds custom icons to the top level admin menus. Admin menu icons are located
 * in the EXMACHINA_ADMIN_IMAGES 'icons' directory.
 *
 * @link   http://randyjensenonline.com/thoughts/wordpress-custom-post-type-fugue-icons/
 *
 * @since  0.3.0
 * @return void
 */
function exmachina_custom_admin_icons() {
    ?>
        <style type="text/css" media="screen">
            #toplevel_page_theme-settings .wp-menu-image {
              background: url(<?php echo trailingslashit( EXMACHINA_ADMIN_IMAGES ) . 'icons/control-power.png'; ?>) no-repeat 6px -17px !important;
            }
            #toplevel_page_theme-settings:hover .wp-menu-image,
            #toplevel_page_theme-settings.current .wp-menu-image,
            #toplevel_page_theme-settings.wp-has-current-submenu .wp-menu-image {
              background-position:6px 7px!important;
            }
        </style>
    <?php
} // end function exmachina_custom_admin_icons()

/**
 * Register Admin CSS Stylesheets
 *
 * Registers the framework's 'admin.css' stylesheet file. The function does not
 * load the stylesheet. It merely registers it with WordPress.
 *
 * @see http://codex.wordpress.org/Function_Reference/wp_register_style
 * @todo  prepare custom build uikit
 *
 * @since 2.2.3
 * @return void
 */
function exmachina_admin_register_styles() {

  /* Use the .min stylesheet if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  wp_register_style( 'exmachina-core-admin-css', trailingslashit( EXMACHINA_ADMIN_CSS ) . "admin{$suffix}.css", false, EXMACHINA_VERSION, 'screen' );
} // end function exmachina_admin_register_styles()

/**
 * Register Admin JS JavaScripts
 *
 * Registers the framework's 'admin.js' javascript file. The function does not
 * load the javascript. It merely registers it with WordPress.
 *
 * @see http://codex.wordpress.org/Function_Reference/wp_register_script
 * @todo  bring back minified scripts "admin{$suffix}.js"
 * @todo  prepare custom build uikit
 *
 * @since 2.2.3
 * @return void
 */
function exmachina_admin_register_scripts() {

  /* Use the .min script if SCRIPT_DEBUG is turned off. */
  $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

  wp_register_script( 'exmachina-core-uikit-js', esc_url( trailingslashit( EXMACHINA_ADMIN_VENDOR ) . "uikit/js/uikit{$suffix}.js" ), array( 'jquery' ), '1.0.2', true );
  wp_register_script( 'exmachina-core-admin-js', esc_url( trailingslashit( EXMACHINA_ADMIN_JS ) . "admin.js" ), array( 'jquery' ), EXMACHINA_VERSION, true );

} // end function exmachina_admin_register_scripts()

