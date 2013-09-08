<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Theme Settings
 *
 * theme-settings.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * Handles the display and functionality of the theme settings page. This provides
 * the needed hooks and meta box calls to create any number of theme settings needed.
 * This file is only loaded if the theme supports the 'exmachina-core-theme-settings'
 * feature.
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

/**
 * Theme Settings Admin Subclass
 *
 * Registers a new admin page, providing content and corresponding menu item for
 * the Theme Settings page.
 *
 * @since 0.2.0
 */
class ExMachina_Admin_Theme_Settings extends ExMachina_Admin_Metaboxes {

  /**
   * Theme Settings Class Constructor
   *
   * Creates an admin menu item and settings page.
   *
   * @since 0.2.0
   */
  function __construct() {

    /* Get theme information. */
    $theme = wp_get_theme( get_template(), get_theme_root( get_template_directory() ) );

    /* Get menu titles. */
    $menu_title = __( 'Theme Settings', 'exmachina-core' );
    $page_title = sprintf( esc_html__( '%1s %2s', 'exmachina-core' ), $theme->get( 'Name' ), $menu_title );

    /* Specify the unique page id. */
    $page_id = 'theme-settings';

    /* Define page titles and menu position. Can be filtered using 'exmachina_theme_settings_menu_ops'. */
    $menu_ops = apply_filters(
      'exmachina_theme_settings_menu_ops',
      array(
        'main_menu' => array(
          'sep' => array(
            'sep_position'   => '58.995',
            'sep_capability' => 'edit_theme_options',
          ),
          'page_title' => $page_title,
          'menu_title' => $theme->get( 'Name' ),
          'capability' => 'edit_theme_options',
          'icon_url'   => 'div',
          'position'   => '58.996',
        ),
        'first_submenu' => array( //* Do not use without 'main_menu'
          'page_title' => $page_title,
          'menu_title' => $menu_title,
          'capability' => 'edit_theme_options',
        ),
        'theme_submenu' => array( //* Do not use without 'main_menu'
          'page_title' => $page_title,
          'menu_title' => $menu_title,
          'capability' => 'edit_theme_options',
        ),
      )
    );

    /* Define page options (notice text and screen icon). Can be filtered using 'exmachina_theme_settings_page_ops'. */
    $page_ops = apply_filters(
      'exmachina_theme_settings_page_ops',
      array(
        'screen_icon'       => 'options-general',
        'save_button_text'  => __( 'Save Settings', 'exmachina-core' ),
        'reset_button_text' => __( 'Reset Settings', 'exmachina-core' ),
        'saved_notice_text' => __( 'Settings saved.', 'exmachina-core' ),
        'reset_notice_text' => __( 'Settings reset.', 'exmachina-core' ),
        'error_notice_text' => __( 'Error saving settings.', 'exmachina-core' ),
      )
    );

    /* Set the unique settings field id. */
    $settings_field = EXMACHINA_SETTINGS_FIELD;

    /* Define the default setting values. Can be filtered using 'exmachina_theme_settings_defaults'. */
    $default_settings = apply_filters(
      'exmachina_theme_settings_defaults',
      array(
        'theme_version' => EXMACHINA_VERSION,
        'db_version'    => EXMACHINA_DB_VERSION,
        'test_setting'   => __( 'This is the test setting default.', 'exmachina-core' ),
      )
    );

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    /* Initialize the sanitization filter. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );

  } // end function __construct()

  /**
   * Theme Settings Sanitizer Filters
   *
   * Register each of the settings with a sanitization filter type.
   *
   * @uses exmachina_add_option_filter() Assign a sanitization filter to an array of settings.
   *
   * @since 0.1.0
   */
  public function sanitizer_filters() {

    exmachina_add_option_filter( 'safe_html', $this->settings_field,
      array(
        'test_setting',
    ) );

  } // end function sanitizer_filters()

  /**
   * Theme Settings Help Tabs
   *
   * Setup contextual help tabs content.
   *
   * @todo  create help sidebar variables (possibly using the CSS technique)
   *
   * @since 0.1.0
   */
  public function settings_page_help() {

    $screen = get_current_screen();

    /* Add the 'Sample Help' help content. */
    $sample_help =
      '<h3>' . __( 'Theme Settings', 'exmachina' ) . '</h3>' .
      '<p>'  . __( 'Help content goes here.' ) . '</p>';

    /* Adds the 'Sample Help' help tab. */
    $screen->add_help_tab( array(
      'id'      => $this->pagehook . '-sample-help',
      'title'   => __( 'Sample Help', 'exmachina' ),
      'content' => $sample_help,
    ) );

    /* Adds help sidebar content. */
    $screen->set_help_sidebar(
      '<p><strong>' . __( 'For more information:', 'exmachina' ) . '</strong></p>' .
      '<p><a href="http://my.machinathemes.com/help/" target="_blank" title="' . __( 'Get Support', 'exmachina' ) . '">' . __( 'Get Support', 'exmachina' ) . '</a></p>' .
      '<p><a href="http://my.machinathemes.com/snippets/" target="_blank" title="' . __( 'ExMachina Snippets', 'exmachina' ) . '">' . __( 'ExMachina Snippets', 'exmachina' ) . '</a></p>' .
      '<p><a href="http://my.machinathemes.com/tutorials/" target="_blank" title="' . __( 'ExMachina Tutorials', 'exmachina' ) . '">' . __( 'ExMachina Tutorials', 'exmachina' ) . '</a></p>'
    );

    /* Trigger the help content action hook. */
    do_action( 'exmachina_theme_settings_help', $this->pagehook );

  } // end function settings_page_help()

  /**
   * Theme Settings Load Metaboxes
   *
   * Register metaboxes on the theme settings page.
   *
   * @since 0.1.0
   */
  public function settings_page_load_metaboxes() {

    /* Adds hidden fields before the theme settings metabox display. */
    add_action( $this->pagehook . '_admin_before_metaboxes', array( $this, 'hidden_fields' ) );

    add_meta_box('test_metabox', 'Test Metabox', array( $this, 'display_test_metabox' ), $this->pagehook, 'normal', 'high');

    /* Trigger the theme settings metabox action hook. */
    do_action( 'exmachina_theme_settings_metaboxes', $this->pagehook );

  } // end function settings_page_load_metaboxes()

  /**
   * Theme Settings Hidden Fields
   *
   * Echo hidden form fields before the metaboxes.
   *
   * @since 0.1.0
   *
   * @param  string $pagehook Current page hook.
   * @return null             Returns early if not set to the correct admin page.
   */
  function hidden_fields( $pagehook ) {

    if ( $pagehook !== $this->pagehook )
      return;

    printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'theme_version' ), esc_attr( $this->get_field_value( 'theme_version' ) ) );
    printf( '<input type="hidden" name="%s" value="%s" />', $this->get_field_name( 'db_version' ), esc_attr( $this->get_field_value( 'db_version' ) ) );

  } // end function hidden_fields()

  /**
   * Theme Settings Test Metabox
   *
   * Callback function for the Theme Settings Test Metabox.
   *
   * @since 0.1.0
   */
  function display_test_metabox() { ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'test_setting' ); ?>"><?php _e( 'Enter your test setting:', 'exmachina' ); ?></label><br />
      <input type="text" name="<?php echo $this->get_field_name( 'test_setting' ); ?>" id="<?php echo $this->get_field_id( 'test_setting' ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'test_setting' ) ); ?>" size="50" />
    </p>

    <p><span class="description"><?php printf( __( 'This is a setting for testing purposes.', 'exmachina' ) ); ?></span></p>

  <?php
  } // end display_test_metabox()

} // end class ExMachina_Admin_Theme_Settings

add_action( 'admin_menu', 'exmachina_add_theme_settings_page' );
/**
 * Add Theme Settings Page
 *
 * Initializes a new instance of the ExMachina_Admin_Theme_Settings and adds
 * the Theme Settings Page.
 *
 * @since 0.1.0
 */
function exmachina_add_theme_settings_page() {

  /* Globalize the $_exmachina_admin_theme_settings variable. */
  global $_exmachina_admin_theme_settings;

  /* Create a new instance of the ExMachina_Admin_Theme_Settings class. */
  $_exmachina_admin_theme_settings = new ExMachina_Admin_Theme_Settings;

} // end function exmachina_add_theme_settings_page()