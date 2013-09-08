<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * <[THEME NAME]> WordPress Theme
 * Main Theme Functions
 *
 * functions.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Please do all modifications in the form
 * of a child theme.
 *
 * The functions file is used to initialize everything in the theme. It controls
 * how the theme is loaded and sets up the supported features, default actions,
 * and default filters.  If making customizations, users should create a child
 * theme and make changes to its functions.php file (not this one).
 *
 * @package     <[THEME NAME]>
 * @subpackage  Functions
 * @author      Machina Themes <[email]>
 * @copyright   Copyright(c) 2012-2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com/
 */
###############################################################################
# begin functions
###############################################################################

/* Load the core theme framework. */
//require_once( trailingslashit( get_template_directory() ) . 'library/engine.php' );
//new ExMachina();

/* Do theme setup on the 'exmachina_init' hook. */
//add_action( 'exmachina_init', 'optimus_theme_setup' );

/**
 * Theme Setup Function
 *
 * This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since 0.1.0
 * @access public
 * @return void
 */
function optimus_theme_setup() {

  /* Get action/filter hook prefix. */
  $prefix = exmachina_get_prefix();

} // end function optimus_theme_setup()