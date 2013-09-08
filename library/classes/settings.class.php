<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Settings Builder Class
 *
 * settings.class.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <DESCRIPTION GOES HERE>
 *
 * @todo finish writing this class
 *
 * @package     ExMachina
 * @subpackage  Classes
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Begin class
###############################################################################

class ExMachina_Settings {

  /**
   * Settings Class Public Variables
   *
   * Defines the public variables that will be used throughout the class and the
   * extended subclasses.
   *
   * @since 0.2.3
   *
   * @var string $title
   * @var string $id
   * @var string $page
   * @var string $context
   * @var string $priority
   * @var array  $fields
   * @var string $hide_ui_if_cannot
   */
  public $title = 'Settings Panel';                   // (string)(required) Title of the edit screen section, visible to user.
  public $slug = 'settings_panel';                      // (string) (required) HTML 'id' attribute of the edit screen section.
  public $page = '$_exmachina_admin_theme_settings';  // (string) (required) Pagehook to include the metabox panel.
  public $context = 'normal';                         // (string) (required) Column of the settings panel metabox: normal, side, or advanced.
  public $priority = 'default';                       // (string) (required) Load order of the settings panel metabox: high, low, or default.
  public $fields = array();                           // (array) A multi-dimensional array for populating the settings panel metabox.
  public $hide_ui_if_cannot = null;                   // (string) Lowest capability a user must have in order to see the metabox.

  /**
   * Settings Class Constructor
   *
   * <[description goes here]>
   *
   * @uses init() [description]
   * @uses hooks() [description]
   *
   * @since 0.2.3
   */
  public function __construct() {

    /* Return early if network admin. */
    if ( is_network_admin() )
      return;

    add_action( 'admin_init', array( $this, 'init' ), 5 );
    add_action( 'init', array( $this, 'hooks'), 5 );
  } // end function __construct()

  /**
   * Settings Class Call Method
   *
   * This method makes errors less destructive.
   *
   * @since 0.2.3
   *
   * @param  [type] $method [description]
   * @param  [type] $args   [description]
   * @return [type]         [description]
   */
  public function __call( $method, $args ) {

    wp_die( "Your new settings class, <b>" . $this->title . "</b>, is trying to call an unknown method: " . $method );

  } // end function __call()

  /**
   * Settings Class Init
   *
   * This method hooks the metabox to the proper settings page.
   *
   * @todo figure out how to dynamically set the page hook.
   * @todo check that we're using the proper action hook
   *
   * @since 0.2.3
   *
   * @return [type] [description]
   */
  public function init() {

    global $sb_admin, $sb_style;
    $this->page = ($this->page == 'sb_style') ? $sb_style : $sb_admin;

    add_action( 'load-'. $this->page, array( $this, 'metaboxes' ) );
  } // end function init()

  /**
   * Settings Class Add Metaboxes
   *
   * This method creates the metabox.
   *
   * @since 0.2.3
   *
   * @return [type] [description]
   */
  public function metaboxes() {

    if ( empty( $this->hide_ui_if_cannot ) || current_user_can( $this->hide_ui_if_cannot ) )
      add_meta_box( $this->slug, $this->title, array( $this, 'admin_form' ), $this->page, $this->context, $this->priority);

  } // end function metaboxes()

  /**
   * Settings Class Admin Form
   *
   * Create the options form to wrap inside the metabox. Only override this if you want to create your own form.
   *
   * @todo Finish writing this function.
   *
   * @param  [type] $options [description]
   * @return [type]          [description]
   */
  public function admin_form( $options ) {

    $options = ($options) ? $options : $this->options;

    $output = '';

    foreach ( $options as $id => $settings ) {} // end foreach ($options as $id => $settings)

    /* Echo the output. */
    echo $output;

  } // end function admin_form()

  /**
   * Settings Class Output
   *
   * Outputting settings as necessary. Note: You can add as many custom functions as you need.
   *
   * @todo See if this can be an abstract class.
   *
   * @since 0.2.3
   *
   * @return [type] [description]
   */
  public function output() {} // end function output()

  /**
   * Settings Class Hooks
   *
   * For hooking all functions elsewhere. Note: When referencing the function add_action() use: array( &$this, 'function_name' ).
   *
   * @todo See if this can be an abstract class
   *
   * @since 0.2.3
   *
   * @return [type] [description]
   */
  public function hooks() {} // end function hooks()

} // end class ExMachina_Settings

class ExMachina_Settings_Input {} // end class ExMachina_Settings_Input