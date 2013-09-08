<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * Admin Builder Class
 *
 * admin.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * <DESCRIPTION GOES HERE>
 *
 * @todo  update pagehooks to action hooks
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

/**
 * Admin Builder Class
 *
 * Abstract class to create menus and settings pages (with or without sortable
 * metaboxes). This class is extended by subclasses that define specific types
 * of admin pages.
 *
 * @since 0.2.0
 */
abstract class ExMachina_Admin {

  /**
   * Admin Class Public Variables
   *
   * Defines the public variables that will be used throughout the class and the
   * extended subclasses.
   *
   * @since 0.2.0
   *
   * @var string  $pagehook         Name of the page hook when it is registered.
   * @var string  $page_id          ID of the admin menu and settings page.
   * @var string  $settings_field   Name of the settings field in the options table.
   * @var array   $default_settings Associative array for the default settings.
   * @var array   $menu_ops         Associative array of config options for the admnin menu(s).
   * @var array   $page_ops         Associative array of config options for the settings page.
   */
  public $pagehook;         // Name of the page hook when the menu page is registered.
  public $page_id;          // ID of the admin menu and settings page.
  public $settings_field;   // Name of the settings field in the options table.
  public $default_settings; // Associative array (field name => value) for the default settings.
  public $menu_ops;         // Associative array of configuration options for the admin menu(s).
  public $page_ops;         // Associative array of configuration options for the settings page.

  /**
   * Admin Page Creator
   *
   * Call this method in a subclass constructor to create an admin menu and
   * settings page.
   *
   * @uses maybe_add_main_menu()     Possibly create a new top level admin menu.
   * @uses maybe_add_first_submenu() Possibly create the first submenu item.
   * @uses maybe_add_submenu()       Possibly create a submenu item.
   * @uses register_settings()       Register the database settings for storage.
   * @uses notices()                 Display notices on the save or reset of settings.
   * @uses settings_init()           Initialize the settings page.
   * @uses save()                    Save method.
   *
   * @since 0.2.0
   *
   * @param  string $page_id          ID of the admin menu and settings page.
   * @param  array  $menu_ops         Optional. Config options for admin menu(s). Default is empty array.
   * @param  array  $page_ops         Optional. Config options for settings page. Default is empty array.
   * @param  string $settings_field   Optional. Name of the settings field. Default is an empty string.
   * @param  array  $default_settings Optional. Field name => values for default settings. Default is empty array.
   * @return nul                      Return early if page ID is not set.
   */
  public function create( $page_id = '', array $menu_ops = array(), array $page_ops = array(), $settings_field = '', array $default_settings = array() ) {

    /* Set up the constructor properties. */
    $this->page_id          = $this->page_id          ? $this->page_id          : $page_id;
    $this->menu_ops         = $this->menu_ops         ? $this->menu_ops         : (array) $menu_ops;
    $this->page_ops         = $this->page_ops         ? $this->page_ops         : (array) $page_ops;
    $this->settings_field   = $this->settings_field   ? $this->settings_field   : $settings_field;
    $this->default_settings = $this->default_settings ? $this->default_settings : (array) $default_settings;

    /* Format $page_id as an action and filter hook. */
    $this->pagehook = str_replace('-', '_', $this->page_id);

    /* Set the $page_ops defaults. */
    $page_ops_defaults = array(
      'screen_icon'       => 'options-general',
      'save_button_text'  => __( 'Save Settings', 'exmachina' ),
      'reset_button_text' => __( 'Reset Settings', 'exmachina' ),
      'saved_notice_text' => __( 'Settings saved.', 'exmachina' ),
      'reset_notice_text' => __( 'Settings reset.', 'exmachina' ),
      'error_notice_text' => __( 'Error saving settings.', 'exmachina' ),
    );

    /* Parse the $page_ops arguments. */
    $this->page_ops = wp_parse_args( $this->page_ops, $page_ops_defaults );

    /* Apply the $page_ops default filters. */
    $this->page_ops = apply_filters( 'exmachina_' . $this->pagehook . 'create_page_ops', $this->page_ops );

    /* Apply the $menu_ops default filters. */
    $this->menu_ops = apply_filters( 'exmachina_' . $this->pagehook . 'create_menu_ops', $this->menu_ops );

    /* Apply the $settings_field default filters. */
    $this->settings_field = apply_filters( 'exmachina_' . $this->pagehook . 'create_settings_field', $this->settings_field );

    /* Apply the $default_settings default filters. */
    $this->default_settings = apply_filters( 'exmachina_' . $this->pagehook . 'create_default_settings', $this->default_settings );

    /* Do nothing if page_id not set. */
    if ( ! $this->page_id )
      return;

    /* Check to make sure there we are only creating one menu per subclass. */
    if ( isset( $this->menu_ops['submenu'] ) && ( isset( $this->menu_ops['main_menu'] ) || isset( $this->menu_ops['first_submenu'] ) ) )
      wp_die( sprintf( __( 'You cannot use %s to create two menus in the same subclass. Please use separate subclasses for each menu.', 'exmachina' ), 'ExMachina_Admin' ) );

    /* Create the menu(s). Conditional logic happens within the separate methods. */
    add_action( 'admin_menu', array( $this, 'maybe_add_main_menu' ), 5 );
    add_action( 'admin_menu', array( $this, 'maybe_add_first_submenu' ), 5 );
    add_action( 'admin_menu', array( $this, 'maybe_add_submenu' ) );
    add_action( 'admin_menu', array( $this, 'maybe_add_theme_submenu' ), 5 );

    /* Set up settings and notices. */
    add_action( 'admin_init', array( $this, 'register_settings' ) );
    add_action( 'admin_notices', array( $this, 'notices' ) );

    /* Load the page content (metaboxes or custom form). */
    add_action( 'admin_init', array( $this, 'settings_init' ) );

    /* Add a sanitizer/validator. */
    add_filter( 'pre_update_option_' . $this->settings_field, array( $this, 'save' ), 10, 2 );

  } // end function create()

  /**
   * Maybe Add Main Menu
   *
   * Possibly create a new top-level admin menu (with or without separator).
   *
   * @see http://codex.wordpress.org/Function_Reference/add_menu_page
   *
   * @uses settings_page() Settings page callback function.
   *
   * @since 0.2.0
   */
  public function maybe_add_main_menu() {

    /* Maybe add a menu separator. */
    if ( isset( $this->menu_ops['main_menu']['sep'] ) ) {
      $sep = wp_parse_args(
        $this->menu_ops['main_menu']['sep'],
        array(
          'sep_position'   => '', // The separator position.
          'sep_capability' => '', // The separator capability.
        )
      );

      if ( $sep['sep_position'] && $sep['sep_capability'] )
        $GLOBALS['menu'][$sep['sep_position']] = array( '', $sep['sep_capability'], 'separator', '', 'exmachina-separator wp-menu-separator' );
    } // end if (isset($this->menu_ops['main_menu']['sep']))

    /* Maybe add main menu. */
    if ( isset( $this->menu_ops['main_menu'] ) && is_array( $this->menu_ops['main_menu'] ) ) {
      $menu = wp_parse_args(
        $this->menu_ops['main_menu'],
        array(
          'page_title' => '',                   // (string) (required) The text to be displayed in the title tags of the page when the menu is selected.
          'menu_title' => '',                   // (string) (required) The on-screen name text for the menu.
          'capability' => 'edit_theme_options', // (string) (required) The capability required for this menu to be displayed to the user.
          'icon_url'   => '',                   // (string) (optional) The url to the icon to be used for this menu.
          'position'   => '',                   // (integer) (optional) The position in the menu order this menu should appear.
        )
      );

      /* Create the main menu page. */
      $this->pagehook = add_menu_page( $menu['page_title'], $menu['menu_title'], $menu['capability'], $this->page_id, array( $this, 'settings_page' ), $menu['icon_url'], $menu['position'] );
    } // end if (isset($this->menu_ops['main_menu']) && is_array($this->menu_ops['main_menu']))

  } // end function maybe_add_main_menu()

  /**
   * Maybe Add First Submenu
   *
   * Possibly create the first submneu item. This method takes the gueswork out
   * of creating a submenu of the top-level menu item.
   *
   * @see http://codex.wordpress.org/Function_Reference/add_submenu_page
   *
   * @uses settings_page() Settings page callback function.
   *
   * @since 0.2.0
   */
  public function maybe_add_first_submenu() {

    /* Maybe add first submenu. */
    if ( isset( $this->menu_ops['first_submenu'] ) && is_array( $this->menu_ops['first_submenu'] ) ) {
      $menu = wp_parse_args(
        $this->menu_ops['first_submenu'],
        array(
          'page_title' => '',                   // (string) (required) The text to be displayed in the title tags of the page when the menu is selected.
          'menu_title' => '',                   // (string) (required) The text to be used for the menu.
          'capability' => 'edit_theme_options', // (string) (required) The capability required for this menu to be displayed to the user.
        )
      );

      /* Create the first submenu page. */
      $this->pagehook = add_submenu_page( $this->page_id, $menu['page_title'], $menu['menu_title'], $menu['capability'], $this->page_id, array( $this, 'settings_page' ) );
    } // end if (isset($this->menu_ops['first_submenu']) && is_array($this->menu_ops['first_submenu']))

  } // end function maybe_add_first_submenu()

  /**
   * Maybe Add Submenu
   *
   * Possibly create a submneu item.
   *
   * @see http://codex.wordpress.org/Function_Reference/add_submenu_page
   *
   * @uses settings_page() Settings page callback function.
   *
   * @since 0.2.0
   */
  public function maybe_add_submenu() {

    /* Maybe add submenu. */
    if ( isset( $this->menu_ops['submenu'] ) && is_array( $this->menu_ops['submenu'] ) ) {
      $menu = wp_parse_args(
        $this->menu_ops['submenu'],
        array(
          'parent_slug' => '',                   // (string) (required) The slug name for the parent menu (or the file name of a standard WordPress admin page).
          'page_title'  => '',                   // (string) (required) The text to be displayed in the title tags of the page when the menu is selected.
          'menu_title'  => '',                   // (string) (required) The text to be used for the menu.
          'capability'  => 'edit_theme_options', // (string) (required) The capability required for this menu to be displayed to the user.
        )
      );

      /* Create the submenu page. */
      $this->pagehook = add_submenu_page( $menu['parent_slug'], $menu['page_title'], $menu['menu_title'], $menu['capability'], $this->page_id, array( $this, 'settings_page' ) );
    } // end if (isset($this->menu_ops['submenu']) && is_array($this->menu_ops['submenu']))

  } // end function maybe_add_submenu()

  /**
   * Maybe Add Theme Page
   *
   * Possibly create a theme page.
   *
   * @see http://codex.wordpress.org/Function_Reference/add_theme_page
   *
   * @uses settings_page() Admin page callback method.
   *
   * @since 0.2.0
   * @return void
   */
  public function maybe_add_theme_submenu() {

    /* Maybe add theme submenu. */
    if ( isset( $this->menu_ops['theme_submenu'] ) && is_array( $this->menu_ops['theme_submenu'] ) ) {
      $menu = wp_parse_args(
        $this->menu_ops['theme_submenu'],
        array(
          'page_title' => '', // (string) (required) The text to be displayed in the title tags of the page when the menu is selected.
          'menu_title' => '', // (string) (required) The text to be used for the menu.
          'capability' => 'edit_theme_options', // (string) (required) The capability required for this menu to be displayed to the user.
        )
      );

      /* Create the theme page. */
      $this->pagehook = add_theme_page( $menu['page_title'], $menu['menu_title'], $menu['capability'], $this->page_id, array( $this, 'settings_page' ) );
    } // end if(isset($this->menu_ops['theme_submenu']) && is_array($this->menu_ops['theme_submenu']))

  } // end function maybe_add_theme_submenu()

  /**
   * Register Settings
   *
   * Registers the database settings for storage.
   *
   * @see http://codex.wordpress.org/Function_Reference/register_setting
   * @see http://codex.wordpress.org/Function_Reference/add_option
   * @see http://codex.wordpress.org/Function_Reference/update_option
   *
   * @uses exmachina_is_menu_page()   Conditional menu page check.
   * @uses exmachina_get_option()     Retrives the option from the settings field.
   * @uses exmachina_admin_redirect() Admin page redirect.
   *
   * @since 0.2.0
   *
   * @return null Return early if not on the correct admin page.
   */
  public function register_settings() {

    /* If this page doesn't store settings, no need to register them. */
    if ( ! $this->settings_field )
      return;

    /* Register the settings and add the default options. */
    register_setting( $this->settings_field, $this->settings_field );
    add_option( $this->settings_field, $this->default_settings );

    /* If not on an admin page, return. */
    if ( ! exmachina_is_menu_page( $this->page_id ) )
      return;

    /* Redirect to the 'reset' or 'error' page arguments. */
    if ( exmachina_get_option( 'reset', $this->settings_field ) ) {
      if ( update_option( $this->settings_field, $this->default_settings ) )
        exmachina_admin_redirect( $this->page_id, array( 'reset' => 'true' ) );
      else
        exmachina_admin_redirect( $this->page_id, array( 'error' => 'true' ) );
      exit;
    } // end if (exmachina_get_option('reset', $this->settings_field))

  } // end function register_settings()

  /**
   * Settings Page Notices
   *
   * Display notices on the save or reset of settings.
   *
   * @see http://codex.wordpress.org/Function_Reference/settings_errors
   * @see http://codex.wordpress.org/Function_Reference/add_settings_error
   *
   * @uses exmachina_is_menu_page() Conditional menu page check.
   *
   * @since 0.2.0
   *
   * @return null Return early if not on the correct admin page.
   */
  public function notices() {

    /* Return if not on the correct admin page. */
    if ( ! exmachina_is_menu_page( $this->page_id ) )
      return;

    /* Display the save settings notice. */
    if ( isset( $_REQUEST['settings-updated'] ) && 'true' === $_REQUEST['settings-updated'] )
      //echo '<div id="message" class="updated"><p><strong>' . $this->page_ops['saved_notice_text'] . '</strong></p></div>';
      add_settings_error( $this->pagehook . '-notices', 'exmachina-settings-updated', $this->page_ops['saved_notice_text'], 'updated fade in' );

    /* Display the reset settings notice. */
    elseif ( isset( $_REQUEST['reset'] ) && 'true' === $_REQUEST['reset'] )
      //echo '<div id="message" class="updated"><p><strong>' . $this->page_ops['reset_notice_text'] . '</strong></p></div>';
      add_settings_error( $this->pagehook . '-notices', 'exmachina-settings-reset', $this->page_ops['reset_notice_text'], 'updated' );

    /* Display the error settings notice. */
    elseif ( isset( $_REQUEST['error'] ) && 'true' === $_REQUEST['error'] )
      //echo '<div id="message" class="updated"><p><strong>' . $this->page_ops['error_notice_text'] . '</strong></p></div>';
      add_settings_error( $this->pagehook . '-notices', 'exmachina-settings-error', $this->page_ops['error_notice_text'], 'error' );

  } // end function notices()

  /**
   * Save Method
   *
   * Override this method to modify the form data (for validation, sanitization,
   * etc.) before it gets saved.
   *
   * @since 0.2.0
   *
   * @param  string $newvalue New value.
   * @param  string $oldvalue Old value.
   * @return string           Returns the new value.
   */
  public function save( $newvalue, $oldvalue ) {

    return $newvalue;

  } // end function save()

  /**
   * Settings Page Init
   *
   * Initialize the settings page. This method must be re-defined in an extended
   * subclass to hook in the required components of the page.
   *
   * @since 0.2.0
   */
  abstract public function settings_init();

  /**
   * Settings Page Output
   *
   * Outputs the main admin page. This method must be re-defined in an extended
   * subclass to output the main admin page content.
   *
   * @since 0.2.0
   */
  abstract public function settings_page();

  /**
   * Get Field Name
   *
   * Helper function that constructs name attributes for use in the form fields.
   *
   * @since 0.2.0
   *
   * @param  string $name Field name base.
   * @return string       Full field name.
   */
  protected function get_field_name( $name ) {

    return sprintf( '%s[%s]', $this->settings_field, $name );

  } // end function get_field_name()

  /**
   * Get Field ID
   *
   * Helper function that constructs id attributes for use in the form fields.
   *
   * @since 0.2.0
   *
   * @param  string $id Field id base.
   * @return string     Full field id.
   */
  protected function get_field_id( $id ) {

    return sprintf( '%s[%s]', $this->settings_field, $id );

  } // end function get_field_id()

  /**
   * Get Field Value
   *
   * Helper function that returns a setting value from this form's setting
   * field for use in the form fields.
   *
   * @uses exmachina_get_option() Returns the option from the options table.
   *
   * @since 0.2.0
   *
   * @param  string $key Field key.
   * @return string      Full field value.
   */
  protected function get_field_value( $key ) {

    return exmachina_get_option( $key, $this->settings_field );

  } // end function get_field_value()

} // end class ExMachina_Admin

/**
 * Basic Admin Class
 *
 * Abstract subclass of ExMachina_Admin which adds support for creating a basic
 * admin page that doesn't make use of a Settings API form or metaboxes.
 *
 * This class must be extended when creating a basic admin page and the admin()
 * method must be redefined.
 *
 * @since 0.2.0
 */
abstract class ExMachina_Admin_Basic extends ExMachina_Admin {

  /**
   * Basic Admin Settings Init
   *
   * Satisfies the abstract requirements of the ExMachina_Admin class. This
   * method can be redefined within the page-specific implementation class
   * if something needs to hook into 'admin_init'.
   *
   * @since 0.2.0
   */
  public function settings_init() {

    /* Load help tabs if 'settings_page_help' method exists. */
    if ( method_exists( $this, 'settings_page_help' ) )
      add_action( 'load-' . $this->pagehook, array( $this, 'settings_page_help' ) );

  } // end function settings_init()

} // end class ExMachina_Admin_Basic

/**
 * Form Admin Class
 *
 * Abstract subclass of ExMachina_Admin which adds support for displaying a form.
 *
 * This class must be extended when creating an admin page with a form, and the
 * settings_form() method must be defined in the subclass.
 *
 * @since 0.2.0
 */
abstract class ExMachina_Admin_Form extends ExMachina_Admin {

  /**
   * Form Admin Settings Init
   *
   * Initialize the settings page by hooking the form method into the page.
   *
   * @since 0.2.0
   */
  public function settings_init() {

    /* Adds the 'settings_form' method to the page-specific action hook. */
    add_action( $this->pagehook . '_settings_page_form', array( $this, 'settings_form' ) );

    /* Load help tabs if 'settings_page_help' method exists. */
    if ( method_exists( $this, 'settings_page_help' ) )
      add_action( 'load-' . $this->pagehook, array( $this, 'settings_page_help' ) );

  } // end function settings_init()

  /**
   * Admin Form Settings Page Output
   *
   * Use this as the settings admin callback to create an admin page. Includes
   * the necessary markup, form elements, etc.
   *
   * Hook into {$this->pagehook}_settings_page_form to insert table and settings
   * form. Can be overridden in a child class to achieve complete control over
   * the settings page output.
   *
   * @see http://codex.wordpress.org/Function_Reference/settings_fields
   * @see http://codex.wordpress.org/Function_Reference/screen_icon
   * @see http://codex.wordpress.org/Function_Reference/submit_button
   *
   * @uses get_field_name() Gets the field name from the settings field.
   *
   * @todo possibly abstract top-buttons and bottom-buttons to action hook
   * @todo maybe add settings_errors()
   *
   * @since 0.2.0
   */
  public function settings_page() {

    ?>
    <?php do_action( $this->pagehook . '_before_settings_page', $this->pagehook ); ?>

    <div class="wrap">

      <?php do_action( $this->pagehook . '_open_settings_page', $this->pagehook ); ?>

      <form method="post" action="options.php">

        <?php settings_fields( $this->settings_field ); ?>

        <?php screen_icon( $this->page_ops['screen_icon'] ); ?>
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

        <div class="top-buttons">
          <?php
          submit_button( $this->page_ops['save_button_text'], 'primary', 'submit', false );
          submit_button( $this->page_ops['reset_button_text'], 'secondary exmachina-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) );
          ?>
        </div><!-- .top-buttons -->

        <?php do_action( $this->pagehook . '_settings_page_form', $this->pagehook ); ?>

        <div class="bottom-buttons">
          <?php
          submit_button( $this->page_ops['save_button_text'], 'primary', 'submit', false );
          submit_button( $this->page_ops['reset_button_text'], 'secondary exmachina-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) );
          ?>
        </div><!-- .bottom-buttons -->

      </form>

      <?php do_action( $this->pagehook . '_close_settings_page', $this->pagehook ); ?>

    </div><!-- .wrap -->

    <?php do_action( $this->pagehook . '_after_settings_page', $this->pagehook ); ?>

    <?php

  } // end function admin()

  /**
   * Settings Form Output
   *
   * Outputs the settings page form elements. Must be overriden in a subclass
   * to work properly.
   *
   * @since 0.2.0
   */
  abstract public function settings_form();

} // end class ExMachina_Admin_Form

/**
 * ExMachina Admin Boxes
 *
 * Abstract subclass of ExMachina_Admin which adds support for registering and
 * displaying metaboxes.
 *
 * This class must be extended when creating an admin page with metaboxes, and
 * the settings_metaboxes()  method must be defined in the subclass.
 *
 * @since 0.2.0
 */
abstract class ExMachina_Admin_Boxes extends ExMachina_Admin {

  /**
   * Admin Boxes Settings Init
   *
   * Satisfies the abstract requirements of ExMachina_Admin.
   *
   * Initializes all the theme settings page functionality. This function is used
   * to create the theme settings page, then use that as a launchpad for specific
   * actions that need to be tied to the settings page.
   *
   * @since 0.2.0
   */
  public function settings_init() {

    /* Load settings page scripts. */
    add_action( 'load-' . $this->pagehook, array( $this, 'scripts' ) );

    /* Load metabox callback. */
    add_action( 'load-' . $this->pagehook, array( $this, 'metaboxes' ) );

    /* Filter metaboxes to single column layout. */
    add_filter( 'screen_layout_columns', array( $this, 'layout_columns' ), 10, 2 );

    /* Add metabox markup to settings page hook. */
    add_action( $this->pagehook . '_settings_page_boxes', array( $this, 'do_metaboxes' ) );

    /* Load help tabs if 'settings_page_help' method exists. */
    if ( method_exists( $this, 'settings_page_help' ) )
      add_action( 'load-' . $this->pagehook, array( $this, 'settings_page_help' ) );

  } // end function settings_init()

  /**
   * Enqueue Settings Page Scripts
   *
   * Loads the JavaScript files required for managing the metaboxes on the theme
   * settings page.
   *
   * @since 0.2.0
   */
  public function scripts() {

    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'wp-lists' );
    wp_enqueue_script( 'postbox' );

  } // end function scripts()

  /**
   * Settings Page Layout Columns
   *
   * Make the sortable UI into a single column.
   *
   * @since 0.2.0
   *
   * @param  integer  $columns The number of columns to have on the page.
   * @param  string   $screen  The unique screen id.
   * @return array             Returns array of screen ids and columns
   */
  public function layout_columns( $columns, $screen ) {

    if ( $screen === $this->pagehook ) {
      //* This page should only have 1 column option
      $columns[$this->pagehook] = 1;
    }

    return $columns;

  } // end function layout_columns()

  /**
   * Settings Page Output
   *
   * Settings admin callback to create an admin page with sortable metaboxes.
   * Displays the theme settings page markup and calls do_meta_boxes() to allow
   * additional settings metaboxes to be added to the page.
   *
   * @since 0.2.0
   * @return void
   */
  public function settings_page() {

    ?>
    <div class="wrap exmachina-metaboxes">
    <form method="post" action="options.php">

      <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
      <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
      <?php settings_fields( $this->settings_field ); ?>

      <?php screen_icon( $this->page_ops['screen_icon'] ); ?>
      <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

      <?php settings_errors( $this->pagehook . '-notices' ); ?>

      <p class="top-buttons">
        <?php
        submit_button( $this->page_ops['save_button_text'], 'primary', 'submit', false, array( 'id' => '' ) );
        submit_button( $this->page_ops['reset_button_text'], 'secondary exmachina-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) );
        ?>
      </p>

      <?php do_action( $this->pagehook . '_settings_page_boxes', $this->pagehook ); ?>

      <div class="bottom-buttons">
        <?php
        submit_button( $this->page_ops['save_button_text'], 'primary', 'submit', false, array( 'id' => '' ) );
        submit_button( $this->page_ops['reset_button_text'], 'secondary exmachina-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) );
        ?>
      </div>
    </form>
    </div>
    <script type="text/javascript">
      //<![CDATA[
      jQuery(document).ready( function ($) {
        // close postboxes that should be closed
        $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
        // postboxes setup
        postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
      });
      //]]>
    </script>
    <?php

  } // end function admin()

  /**
   * Do Metaboxes
   *
   * Echo out the do_meta_boxes() and wrapping markup.
   *
   * This method can be overriden in a child class, to adjust the markup
   * surrounding the metaboxes, and optionally call do_meta_boxes() with
   * other contexts. The overwritten method must contain div elements with
   * classes of metabox-holder and postbox-container.
   *
   * @since 0.2.0
   * @global object $wp_meta_boxes
   */
  public function do_metaboxes() {

    global $wp_meta_boxes;

    ?>
    <div class="metabox-holder">
      <div class="postbox-container">
        <?php
        do_action( 'exmachina_admin_before_metaboxes', $this->pagehook );
        do_meta_boxes( $this->pagehook, 'main', null );
        if ( isset( $wp_meta_boxes[$this->pagehook]['column2'] ) )
          do_meta_boxes( $this->pagehook, 'column2', null );
        do_action( 'exmachina_admin_after_metaboxes', $this->pagehook );
        ?>
      </div>
    </div>
    <?php

  } // end function do_metaboxes()

  /**
   * Register the Metaboxes
   *
   * Abstract function to load metaboxes on the theme settings page. Must be
   * overridden in a subclass, or obviously, it won't work.
   *
   * @since 0.2.0
   */
  abstract public function metaboxes();
} // end class ExMachina_Admin_Boxes

/**
 * ExMachina Admin Metaboxes
 *
 * Abstract subclass of ExMachina_Admin which adds support for registering and
 * displaying metaboxes.
 *
 * This class must be extended when creating an admin page with metaboxes, and
 * the settings_metaboxes()  method must be defined in the subclass.
 *
 * @since 0.2.0
 */
abstract class ExMachina_Admin_Metaboxes extends ExMachina_Admin {

  /**
   * Admin Metaboxes Settings Init
   *
   * Satisfies the abstract requirements of ExMachina_Admin.
   *
   * Initializes all the theme settings page functionality. This function is used
   * to create the theme settings page, then use that as a launchpad for specific
   * actions that need to be tied to the settings page.
   *
   * @since 0.2.0
   * @return void
   */
  public function settings_init() {

    /* Load the theme settings meta boxes. */
    add_action( 'load-' . $this->pagehook, array( $this, 'settings_page_load_metaboxes' ) );

    /* Create a hook for adding meta boxes. */
    add_action( 'load-' . $this->pagehook, array( $this, 'settings_page_add_metaboxes' ) );

    /* Display the meta boxes markup. */
    add_action( $this->pagehook . '_settings_page_boxes', array( $this, 'settings_page_do_metaboxes' ) );

    /* Display the save toolbar markup. */
    add_action( $this->pagehook . '_settings_page_toolbar', array( $this, 'settings_page_do_toolbar' ) );

    /* Load the JavaScript and stylesheets needed for the theme settings screen. */
    add_action( 'admin_enqueue_scripts', array( $this, 'settings_page_enqueue_scripts' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'settings_page_enqueue_styles' ) );
    add_action( 'admin_footer-' . $this->pagehook, array( $this, 'settings_page_footer_scripts' ) );

    /* Load help tabs if 'help' method exists. */
    if ( method_exists( $this, 'settings_page_help' ) )
      add_action( 'load-' . $this->pagehook, array( $this, 'settings_page_help' ) );
  } // end function settings_init()

  /**
   * Register the Metaboxes
   *
   * Abstract function to load metaboxes on the theme settings page. Must be
   * overridden in a subclass, or obviously, it won't work.
   *
   * @since 0.2.0
   * @return void
   */
  abstract public function settings_page_load_metaboxes();

  /**
   * Settings Page Output
   *
   * Settings admin callback to create an admin page with sortable metaboxes.
   * Displays the theme settings page markup and calls do_meta_boxes() to allow
   * additional settings metaboxes to be added to the page.
   *
   * @see http://codex.wordpress.org/Function_Reference/screen_icon
   * @see http://codex.wordpress.org/Function_Reference/settings_errors
   * @see http://codex.wordpress.org/Function_Reference/wp_nonce_field
   * @see http://codex.wordpress.org/Function_Reference/settings_fields
   *
   * @since 0.2.0
   * @return void
   */
  public function settings_page() {
    ?>
    <?php do_action( $this->pagehook . '_before_settings_page', $this->pagehook ); ?>

    <div class="wrap exmachina-metaboxes">

      <?php screen_icon( $this->page_ops['screen_icon'] ); ?>

      <h2>
        <?php echo esc_html( get_admin_page_title() ); ?>
        <a href="<?php echo admin_url( 'customize.php' ); ?>" class="add-new-h2"><?php esc_html_e( 'Customize', 'exmachina-core' ); ?></a>
      </h2>

      <?php settings_errors( $this->pagehook . '-notices' ); ?>

      <div class="exmachina-core-settings-wrap">

        <?php do_action( $this->pagehook . '_open_settings_page', $this->pagehook ); ?>
        <form method="post" action="options.php">

          <?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
          <?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
          <?php settings_fields( $this->settings_field ); ?>

          <?php do_action( $this->pagehook . '_settings_page_boxes', $this->pagehook ); ?>
          <div class="clear"></div>
          <?php do_action( $this->pagehook . '_settings_page_toolbar', $this->pagehook ); ?>

        </form><!-- form -->

        <?php do_action( $this->pagehook . '_close_settings_page', $this->pagehook ); ?>

      </div><!-- .exmachina-core-settings-wrap -->

    </div><!-- .wrap .exmachina-metaboxes -->

    <?php do_action( $this->pagehook . '_after_settings_page', $this->pagehook ); ?>
    <?php
  } // end function settings_page()

  /**
   * Settings Page Add Metaboxes
   *
   * Provides a hook for adding additional metaboxes as seen on the post screen
   * layout in the WordPress admin. This hook provides an easy way for themes to
   * load and execute metabox code only on the theme settings page in the admin.
   *
   * @since 0.2.0
   * @return void
   */
  public function settings_page_add_metaboxes() {

    /* Trigger the 'add_meta_boxes' action hook. */
    do_action( 'add_meta_boxes', $this->pagehook );
  } // end function settings_page_add_metaboxes()

  /**
   * Enqueue Settings Page Scripts
   *
   * Loads the JavaScript files required for managing the metaboxes on the theme
   * settings page.
   *
   * @see http://codex.wordpress.org/Function_Reference/wp_enqueue_script
   *
   * @uses exmachina_is_menu_page() Admin page conditional check.
   *
   * @todo actually enqueue admin page JS
   *
   * @since 0.2.0
   * @return void
   */
  public function settings_page_enqueue_scripts() {

    /* Enqueue default WordPress bundled metabox scripts. */
    wp_enqueue_script( 'common' );
    wp_enqueue_script( 'wp-lists' );
    wp_enqueue_script( 'postbox' );

    /* Enqueue admin JavaScript if on the theme settings screen. */

  } // end function settings_enqueue_scripts()

  /**
   * Enqueue Settings Page Stylesheets
   *
   * Loads the required stylesheets for displaying the theme settings page in
   * the WordPress admin.
   *
   * @see http://codex.wordpress.org/Function_Reference/wp_enqueue_style
   *
   * @uses exmachina_is_menu_page() Admin page conditional check.
   *
   * @todo actually enqueue admin page css
   *
   * @since 0.2.0
   * @return void
   */
  public function settings_page_enqueue_styles() {

    /* Short-circuit if not an admin page. */
    //if ( ! exmachina_is_menu_page( $this->page_id ) )
    //  return;

    /* Enqueue admin stylesheet if on the theme settings screen. */

  } // end function settings_enqueue_styles()

  /**
   * Do Metaboxes
   *
   * Echo out the do_meta_boxes() and wrapping markup.
   *
   * This method can be overriden in a child class, to adjust the markup
   * surrounding the metaboxes, and optionally call do_meta_boxes() with
   * other contexts. The overwritten method must contain div elements with
   * classes of metabox-holder and postbox-container.
   *
   * @see http://codex.wordpress.org/Dashboard_Widgets_API
   * @see http://codex.wordpress.org/Function_Reference/do_meta_boxes
   *
   * @since 0.2.0
   * @global object $wp_meta_boxes
   * @return void
   */
  public function settings_page_do_metaboxes() {

    /* Globalize the metabox array. */
    global $wp_meta_boxes;

    ?>
    <div id="poststuff">
      <div id="post-body" class="metabox-holder columns-2">

        <?php do_action( $this->pagehook . '_admin_before_metaboxes', $this->pagehook ); ?>

        <div id="postbox-container-1" class="postbox-container side">
          <?php do_meta_boxes( $this->pagehook, 'side', null ); ?>
        </div><!-- #postbox-container-1 -->

        <div id="postbox-container-2" class="postbox-container normal advanced">
          <?php do_meta_boxes( $this->pagehook, 'normal', null ); ?>
          <?php do_meta_boxes( $this->pagehook, 'advanced', null ); ?>
        </div><!-- #postbox-container-2 -->

      <?php do_action( $this->pagehook . '_admin_after_metaboxes', $this->pagehook ); ?>

      </div><!-- #post-body -->
      <br class="clear">
    </div><!-- #poststuff -->
    <?php
  } // end function settings_page_do_metaboxes()

  /**
   * Do Toolbar
   *
   * Echo out the submit and reset buttons along with the wrapping markup.
   *
   * @see http://codex.wordpress.org/Function_Reference/submit_button
   *
   * @uses get_field_name() Retrieves the 'reset' field name.
   *
   * @todo add CSS styling
   * @todo setup clear button
   * @todo add reset confirmation JS
   *
   * @since 0.2.0
   * @return void
   */
  public function settings_page_do_toolbar() {
    ?>
      <div class="settings-toolbar">
        <h3>
          <?php submit_button( $this->page_ops['save_button_text'], 'primary update-button pull-right', 'submit', false, array( 'id' => '' ) ); ?>
          <?php submit_button( $this->page_ops['reset_button_text'], 'secondary reset-button exmachina-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) ); ?>
          <input type="submit" name="reset" id="reset" class="button-secondary clear-button" value="Clear Options">
        </h3>
      </div><!-- .settings-toolbar -->
    <?php
  } // end function settings_page_do_toolbar()

  /**
   * Settings Page Load Footer Scripts
   *
   * Loads the JavaScript required for toggling the metaboxes on the theme
   * settings page.
   *
   * @since 0.2.0
   * @return void
   */
  public function settings_page_footer_scripts() { ?>
    <script type="text/javascript">
      //<![CDATA[
      jQuery(document).ready( function($) {
        $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
        postboxes.add_postbox_toggles( '<?php echo $this->pagehook; ?>' );
      });
      //]]>
    </script><?php
  } // end function settings_page_footer_scripts()

} // end class ExMachina_Admin_Metaboxes

/**
 * ExMachina Admin Metaboxes Builder
 *
 * Abstract subclass of ExMachina_Admin_Metaboxes which adds support for
 * registering and displaying metaboxes via a metabox class.
 *
 * @since 0.2.0
 */
class ExMachina_Admin_Metaboxes_Builder extends ExMachina_Admin_Metaboxes {

  /**
   * Admin Builder Protected Variables
   *
   * @todo cleanup var descriptions
   *
   * @var array $_settings
   * @var array $_sanitize
   * @var array $_help
   * @var array $_metaboxes
   */
  protected $_settings;
  protected $_sanitize;
  protected $_help;
  protected $_metaboxes;

  /**
   * [__construct description]
   *
   * Create the admin menu and the settings page.
   *
   * @param [type] $settings  [description]
   * @param [type] $sanitize  [description]
   * @param [type] $help      [description]
   * @param [type] $metaboxes [description]
   */
  function __construct( $settings, $sanitize, $help, $metaboxes ) {

    $this->_settings  = $settings;
    $this->_sanitize  = $sanitize;
    $this->_help      = $help;
    $this->_metaboxes = $metaboxes;

    /* Specify a unique page ID. */
    $page_id = $settings['page_id'];

    /* Define the $menu_ops_defaults. */
    $menu_ops_defaults = array(
      'submenu' => array(
        'parent_slug' => 'theme-settings',
        'capability' => 'manage_options',
      )
    );

    /* Parse the $menu_ops arguments. */
    $menu_ops = wp_parse_args( $settings['menu_ops'], $menu_ops_defaults );

    /* Define the $page_ops_defaults. Optional. Uncomment to change. */
    $page_ops_defaults = array(
    //  'screen_icon'       => 'options-general',
    //  'save_button_text'  => __( 'Save Settings', 'exmachina' ),
    //  'reset_button_text' => __( 'Reset Settings', 'exmachina' ),
    //  'saved_notice_text' => __( 'Settings saved.', 'exmachina' ),
    //  'reset_notice_text' => __( 'Settings reset.', 'exmachina' ),
    //  'error_notice_text' => __( 'Error saving settings.', 'exmachina' ),
    );

    /* Parse the $page_ops arguments. */
    $page_ops = wp_parse_args( $settings['page_ops'], $page_ops_defaults );

    /* Define a unique settings field. Options are accessed from exmachina_get_option( '$option_name', '$settings_field' ); */
    $settings_field = $settings['settings_field'];

    /* Define the default values. */
    $default_settings = $settings['default_settings'];

    /* Create the admin page. */
    $this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

    /* Initialize the sanitization filter. */
    add_action( 'exmachina_settings_sanitization_init', array( $this, 'sanitization_filters' ) );

  } // end function __construct()

  /**
   * [sanitization_filters description]
   *
   * Setup the sanitization filters.
   *
   * @return [type] [description]
   */
  function sanitization_filters() {

    foreach( $this->_sanitize as $key => $values )
      exmachina_add_option_filter( $key, $this->settings_field, $values );

  } // end function sanitiation_filters()

  /**
   * [settings_page_load_metaboxes description]
   *
   * Register the metaboxes on the admin page.
   *
   * @todo add multiple metabox support
   *
   * @return [type] [description]
   */
  function settings_page_load_metaboxes() {

    $this->_metaboxes['context'] = isset( $this->_metaboxes['context'] ) ? $this->_metaboxes['context'] : 'normal';
    $this->_metaboxes['priority'] = isset( $this->_metaboxes['priority'] ) ? $this->_metaboxes['priority'] : 'default';

    add_meta_box( $this->_metaboxes['id'], $this->_metaboxes['title'], array( &$this, 'settings_page_display_metabox' ), $this->pagehook, $this->_metaboxes['context'], $this->_metaboxes['priority'] );
  } // end function settings_page_load_metaboxes()

  /**
   * [settings_page_help description]
   *
   * Register contextual help on the admin page.
   *
   * @return [type] [description]
   */
  function settings_page_help() {

    global $my_admin_page;

    $screen = get_current_screen();

    if ( $screen->id != $this->pagehook )
      return;

    $tabs = isset( $this->_help['tab'] ) ? $this->_help['tab'] : array();

    foreach ( $tabs as $tab ) {

      $screen->add_help_tab(
        array(
          'id' => $tab['id'],
          'title' => $tab['title'],
          'content' => $tab['content'],
        )
      );
    } // end foreach ($tabs as $tab)

    $sidebars = isset( $this->_help['sidebar'] ) ? $this->_help['sidebar'] : array();

    foreach ( $sidebars as $sidebar ) {

      $screen->set_help_sidebar( $sidebar );
    } // end foreach ($sidebars as $sidebar)

  } // end function settings_page_help()

  /**
   * [settings_page_display_metabox description]
   * @return [type] [description]
   */
  function settings_page_display_metabox() {} // end function settings_page_display_metabox()

} // end class ExMachina_Admin_Metaboxes_Builder

/* Trigger the 'exmachina_admin_init' action hook. */
do_action( 'exmachina_admin_init' );