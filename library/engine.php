<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * ExMachina WordPress Theme Framework Engine
 * ExMachina Engine
 *
 * engine.php
 *
 * WARNING: This file is part of the ExMachina Framework Engine. DO NOT edit
 * this file under any circumstances. Bad things will happen. Please do all
 * modifications in the form of a child theme.
 *
 * The engine that powers the ExMachina framework. This file controls the load
 * order and theme features used in a theme. ExMachina is a modular system, which
 * means that features are only loaded if they are specifically included within
 * the theme.
 *
 * @package     ExMachina
 * @subpackage  Engine
 * @author      Machina Themes | @machinathemes
 * @copyright   Copyright (c) 2013, Machina Themes
 * @license     http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link        http://www.machinathemes.com
 */
###############################################################################
# Start your engines...
###############################################################################

/**
 * ExMachina Class
 *
 * The ExMachina class launches the framework. This class should be loaded and
 * initialized before anything else within the theme is called.
 *
 * @since 0.1.0
 */
class ExMachina {

  /**
   * ExMachina Constructor
   *
   * Constructor method for the ExMachina class. This method adds other methods
   * of the class to specific hooks within WordPress. It controls the load order
   * of the required files for running the framework.
   *
   * @since 0.1.0
   */
  function __construct() {
    global $exmachina;

    /* Set up an empty class for the global $exmachina object. */
    $exmachina = new stdClass;

    /* Trigger the 'exmachina_pre' action hook. */
    do_action( 'exmachina_pre' );

    /* Define framework, parent theme, and child theme constants. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_constants' ), 1 );

    /* Load the core functions required by the rest of the framework. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_load_core' ), 2 );

    /* Define the settings fields constants (for database storage). */
    add_action( 'exmachina_init', array( &$this, 'exmachina_settings_fields' ), 3 );

    /* Initialize the framework's default actions and filters. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_default_filters' ), 4 );

    /* Language functions and translations setup. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_i18n' ), 5 );

    /* Theme setup function fires here. */

    /* Handle theme supported features. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_theme_support' ), 12 );

    /* Initialize post type supported features. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_post_type_support' ), 13 );

    /* Load the framework files. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_load_classes' ), 14 );

    /* Load the framework files. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_load_framework' ), 15 );

    /* Load the framework extensions. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_load_extensions' ), 16 );

    /* Load the admin files. */
    add_action( 'exmachina_init', array( &$this, 'exmachina_load_admin' ), 17 );

    /* Trigger the 'exmachina_init' action hook. */
    do_action( 'exmachina_init' );

    /* Trigger the 'exmachina_setup' action hook. */
    do_action( 'exmachina_setup' );
  } // end function __construct()

  /**
   * Framework Constants
   *
   * Defines the constant paths for use within the core framework, parent theme,
   * and child theme. Constants prefixed with 'EXMACHINA_' are for use only within
   * the core framework and don't reference other areas of the parent or child theme.
   *
   * @since  0.1.0
   */
  function exmachina_constants() {

    /* Sets the framework info constants. */
    define( 'EXMACHINA_NAME', 'ExMachina');
    define( 'EXMACHINA_VERSION', '2.0.0');
    define( 'EXMACHINA_BRANCH', '2.0' );
    define( 'EXMACHINA_DB_VERSION', '2004' );
    define( 'EXMACHINA_RELEASE_DATE', date_i18n( 'F j, Y', '1357538400' ) );

    /* Get theme data. */
    $current_theme_data  = wp_get_theme();
    $parent_theme_data = get_theme_data( get_template_directory() . '/style.css' );
    $child_theme_data = get_theme_data( get_stylesheet_directory() . '/style.css' );

    /* Get parent theme data. */
    $parent_theme_name = $parent_theme_data['Name'];
    $parent_theme_version = $parent_theme_data['Version'];

    /* Get child theme data. */
    $child_theme_name = $child_theme_data['Name'];
    $child_theme_version = $child_theme_data['Version'];

    /* Get current theme data. */
    $current_theme_name = $current_theme_data->Name;
    $current_theme_version = $current_theme_data->Version;

    /* Sets the parent theme info constants. */
    define( 'PARENT_THEME_NAME', $parent_theme_name );
    define( 'PARENT_THEME_VERSION', $parent_theme_version );

    /* Sets the child theme info constants. */
    define( 'CHILD_THEME_NAME', $child_theme_name );
    define( 'CHILD_THEME_VERSION', $child_theme_version );

    /* Sets the current theme info constants. */
    define( 'CURRENT_THEME_NAME', $current_theme_name );
    define( 'CURRENT_THEME_VERSION', $current_theme_version );

    /* Sets the directory location constants. */
    define( 'PARENT_THEME_DIR', get_template_directory() );
    define( 'CHILD_THEME_DIR', get_stylesheet_directory() );

    /* Sets the directory location URL constants. */
    define( 'PARENT_THEME_URL', get_template_directory_uri() );
    define( 'CHILD_THEME_URL', get_stylesheet_directory_uri() );

    /* Sets the core framework location constants. */
    define( 'EXMACHINA_DIR', trailingslashit( PARENT_THEME_DIR ) . basename( dirname( __FILE__ ) ) );
    define( 'EXMACHINA_URL', trailingslashit( PARENT_THEME_URL ) . basename( dirname( __FILE__ ) ) );

    /* Sets the directory location constants. */
    define( 'EXMACHINA_ADMIN', trailingslashit( EXMACHINA_DIR ) . 'admin' );
    define( 'EXMACHINA_ASSETS', trailingslashit( EXMACHINA_DIR ) . 'assets' );
    define( 'EXMACHINA_CLASSES', trailingslashit( EXMACHINA_DIR ) . 'classes' );
    define( 'EXMACHINA_DOCS', trailingslashit( EXMACHINA_DIR ) . 'docs' );
    define( 'EXMACHINA_EXTENSIONS', trailingslashit( EXMACHINA_DIR ) . 'extensions' );
    define( 'EXMACHINA_FRAMEWORK', trailingslashit( EXMACHINA_DIR ) . 'framework' );
    define( 'EXMACHINA_FUNCTIONS', trailingslashit( EXMACHINA_DIR ) . 'functions' );
    define( 'EXMACHINA_INCLUDES', trailingslashit( EXMACHINA_DIR ) . 'includes' );
    define( 'EXMACHINA_LANGUAGES', trailingslashit( EXMACHINA_DIR ) . 'languages' );
    define( 'EXMACHINA_PLUGINS', trailingslashit( EXMACHINA_DIR ) . 'plugins' );
    define( 'EXMACHINA_STRUCTURE', trailingslashit( EXMACHINA_DIR ) . 'structure' );
    define( 'EXMACHINA_WIDGETS', trailingslashit( EXMACHINA_DIR ) . 'widgets' );

    /* Sets the directory location URL constants. */
    define( 'EXMACHINA_ADMIN_URL', trailingslashit( EXMACHINA_URL ) . 'admin' );
    define( 'EXMACHINA_ASSETS_URL', trailingslashit( EXMACHINA_URL ) . 'assets' );
    define( 'EXMACHINA_CLASSES_URL', trailingslashit( EXMACHINA_URL ) . 'classes' );
    define( 'EXMACHINA_DOCS_URL', trailingslashit( EXMACHINA_URL ) . 'docs' );
    define( 'EXMACHINA_EXTENSIONS_URL', trailingslashit( EXMACHINA_URL ) . 'extensions' );
    define( 'EXMACHINA_FRAMEWORK_URL', trailingslashit( EXMACHINA_URL ) . 'framework' );
    define( 'EXMACHINA_FUNCTIONS_URL', trailingslashit( EXMACHINA_URL ) . 'functions' );
    define( 'EXMACHINA_INCLUDES_URL', trailingslashit( EXMACHINA_URL ) . 'includes' );
    define( 'EXMACHINA_LANGUAGES_URL', trailingslashit( EXMACHINA_URL ) . 'languages' );
    define( 'EXMACHINA_PLUGINS_URL', trailingslashit( EXMACHINA_URL ) . 'plugins' );
    define( 'EXMACHINA_STRUCTURE_URL', trailingslashit( EXMACHINA_URL ) . 'structure' );
    define( 'EXMACHINA_WIDGETS_URL', trailingslashit( EXMACHINA_URL ) . 'widgets' );

    /* Sets the admin directory location constants. */
    define( 'EXMACHINA_ADMIN_ASSETS', trailingslashit( EXMACHINA_ADMIN ) . 'assets' );
    define( 'EXMACHINA_ADMIN_FUNCTIONS', trailingslashit( EXMACHINA_ADMIN ) . 'functions' );
    define( 'EXMACHINA_ADMIN_INCLUDES', trailingslashit( EXMACHINA_ADMIN ) . 'includes' );
    define( 'EXMACHINA_ADMIN_OPTIONS', trailingslashit( EXMACHINA_ADMIN ) . 'options' );

    /* Sets the admin directory location URL constants. */
    define( 'EXMACHINA_ADMIN_ASSETS_URL', trailingslashit( EXMACHINA_ADMIN_URL ) . 'assets' );
    define( 'EXMACHINA_ADMIN_FUNCTIONS_URL', trailingslashit( EXMACHINA_ADMIN_URL ) . 'functions' );
    define( 'EXMACHINA_ADMIN_INCLUDES_URL', trailingslashit( EXMACHINA_ADMIN_URL ) . 'includes' );
    define( 'EXMACHINA_ADMIN_OPTIONS_URL', trailingslashit( EXMACHINA_ADMIN_URL ) . 'options' );

    /* Sets the admin assets directory location URL constants. */
    define( 'EXMACHINA_ADMIN_CSS', trailingslashit( EXMACHINA_ASSETS_URL ) . 'css' );
    define( 'EXMACHINA_ADMIN_IMAGES', trailingslashit( EXMACHINA_ASSETS_URL ) . 'images' );
    define( 'EXMACHINA_ADMIN_JS', trailingslashit( EXMACHINA_ASSETS_URL ) . 'js' );
    define( 'EXMACHINA_ADMIN_VENDOR', trailingslashit( EXMACHINA_ASSETS_URL ) . 'vendor' );

    /* Sets the assets directory location URL constants. */
    define( 'EXMACHINA_CSS', trailingslashit( EXMACHINA_ASSETS_URL ) . 'css' );
    define( 'EXMACHINA_IMAGES', trailingslashit( EXMACHINA_ASSETS_URL ) . 'images' );
    define( 'EXMACHINA_JS', trailingslashit( EXMACHINA_ASSETS_URL ) . 'js' );
    define( 'EXMACHINA_VENDOR', trailingslashit( EXMACHINA_ASSETS_URL ) . 'vendor' );

  } // end function exmachina_constants()

  /**
   * Load Core Functions
   *
   * Loads the core framework functions. These files are needed before loading
   * anything else in the framework.
   *
   * @since 0.1.0
   */
  function exmachina_load_core() {

    /* Load the core framework functions. */
    require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'core.php' );

    /* Load the context-based functions. */
    require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'context.php' );

    /* Load the core framework internationalization functions. */
    require_once( trailingslashit( EXMACHINA_FRAMEWORK ) . 'i18n.php' );
  } // end function exmachina_load_core()

  /**
   * Framework Settings Fields
   *
   * Defines the settings fields for options table storage within the database.
   *
   * @uses exmachina_get_prefix() Defines the theme prefix.
   *
   * @since 0.2.0
   */
  function exmachina_settings_fields() {
    global $exmachina;

    /* Get the theme prefix. */
    $prefix = exmachina_get_prefix();

    /* Define Settings Field Constants (for DB storage). */
    define( 'EXMACHINA_SETTINGS_FIELD', apply_filters( "{$prefix}_theme_settings_field", "{$prefix}-theme-settings" ) );
    define( 'EXMACHINA_DESIGN_SETTINGS_FIELD', apply_filters( "{$prefix}_design_settings_field", "{$prefix}-design-settings" ) );
    define( 'EXMACHINA_CONTENT_SETTINGS_FIELD', apply_filters( "{$prefix}_content_settings_field", "{$prefix}-content-settings" ) );

  } // end function exmachina_settings_fields()

  /**
   * Default Filters
   *
   * Adds the default framework actions and filters.
   *
   * @todo add meta template filter
   * @todo check to possibly add additional default filters/actions
   *
   * @since 0.1.0
   */
  function exmachina_default_filters() {

    /* Remove bbPress theme compatibility if current theme supports bbPress. */
    if ( current_theme_supports( 'bbpress' ) )
      remove_action( 'bbp_init', 'bbp_setup_theme_compat', 8 );

    /* Move the WordPress generator to a better priority. */
    remove_action( 'wp_head', 'wp_generator' );
    add_action( 'wp_head', 'wp_generator', 1 );

    /* Make text widgets and term descriptions shortcode aware. */
    add_filter( 'widget_text', 'do_shortcode' );
    add_filter( 'term_description', 'do_shortcode' );

  } // end function exmachina_default_filters()

  /**
   * Load Translation Files
   *
   * Loads both the parent and child theme translation files. If a locale-based
   * functions file exists in either the parent or child theme (child overrides
   * parent), it will also be loaded.
   *
   * @uses exmachina_get_parent_textdomain()      Gets the parent textdomain.
   * @uses exmachina_get_child_textdomain()       Gets the child textdomain.
   * @uses exmachina_load_framework_textdomain()  Loads the framework textdomain.
   *
   * @since 0.1.0
   * @global object $exmachina  The global ExMachina object.
   */
  function exmachina_i18n() {
    global $exmachina;

    /* Get parent and child theme textdomains. */
    $parent_textdomain = exmachina_get_parent_textdomain();
    $child_textdomain = exmachina_get_child_textdomain();

    /* Load the framework textdomain. */
    $exmachina->textdomain_loaded['exmachina-core'] = exmachina_load_framework_textdomain( 'exmachina-core' );

    /* Load theme textdomain. */
    $exmachina->textdomain_loaded[$parent_textdomain] = load_theme_textdomain( $parent_textdomain );

    /* Load child theme textdomain. */
    $exmachina->textdomain_loaded[$child_textdomain] = is_child_theme() ? load_child_theme_textdomain( $child_textdomain ) : false;

    /* Get the user's locale. */
    $locale = get_locale();

    /* Locate a locale-specific functions file. */
    $locale_functions = locate_template( array( "languages/{$locale}.php", "{$locale}.php" ) );

    /* If the locale file exists and is readable, load it. */
    if ( !empty( $locale_functions ) && is_readable( $locale_functions ) )
      require_once( $locale_functions );

  } // end function exmachina_i18n()

  /**
   * Framework Theme Support
   *
   * Activates default theme features and removes theme supported features in
   * the case that the user has a plugin installed that handles the functionality.
   *
   * @since 0.1.0
   */
  function exmachina_theme_support() {

    /* Load custom widgets. */
    add_theme_support( 'exmachina-core-widgets', array( 'archives', 'authors', 'bookmarks', 'calendar', 'categories', 'menu', 'pages', 'search', 'tags', 'user-profile', 'featured-page', 'featured-post', 'social-icons', 'tabs', 'newsletter', ) );
  } // end function exmachina_theme_support()

  /**
   * Framework Post Type Support
   *
   * Initializes post type support for framework supported features.
   *
   * @since 0.1.0
   */
  function exmachina_post_type_support() {} // end function exmachina_post_type_support()

  /**
   * Load Classes
   *
   * Loads all the class files and features. The exmachina_pre_classes
   * action hook is called before any of the files are required.
   *
   * If a parent or child theme defines EXMACHINA_LOAD_CLASSES as false before
   * requiring this engine.php file, then this function will abort before any
   * other files are loaded.
   *
   * @since 0.1.0
   */
  function exmachina_load_classes() {

    /* Triggers the 'exmachina_pre_classes' action hook. */
    do_action( 'exmachina_pre_classes' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_CLASSES' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_CLASSES' ) && EXMACHINA_LOAD_CLASSES === false )
      return;

    /* Load the admin builder class. */
    require_once( trailingslashit( EXMACHINA_CLASSES ) . 'admin.class.php' );

    /* Load the settings sanitization class. */
    require_once( trailingslashit( EXMACHINA_CLASSES ) . 'sanitize.class.php' );

    /* Load the settings builder class. */
    require_once( trailingslashit( EXMACHINA_CLASSES ) . 'settings.class.php' );

  } // end function exmachina_load_classes()

  /**
   * Load Framework
   *
   * Loads all the framework files and features. The exmachina_pre_framework
   * action hook is called before any of the files are required.
   *
   * If a parent or child theme defines EXMACHINA_LOAD_FRAMEWORK as false before
   * requiring this engine.php file, then this function will abort before any
   * other files are loaded.
   *
   * @since 0.1.0
   */
  function exmachina_load_framework() {

    /* Triggers the 'exmachina_pre_framework' action hook. */
    do_action( 'exmachina_pre_framework' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_FRAMEWORK' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_FRAMEWORK' ) && EXMACHINA_LOAD_FRAMEWORK === false )
      return;

    /* Load Functions. */
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'options.php' );
    require_once( trailingslashit( EXMACHINA_FUNCTIONS ) . 'utility.php' );

  } // end function exmachina_load_framework()

  /**
   * Load Extensions
   *
   * Extensions are projects that are included within the framework but are not
   * a part of it. They are external projects developed outside of the framework.
   * Themes must use add_theme_support( $extension ) to use a specific extension
   * within the theme.
   *
   * @since 0.1.0
   */
  function exmachina_load_extensions() {

    /* Triggers the 'exmachina_pre_extensions' action hook. */
    do_action( 'exmachina_pre_extensions' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_EXTENSIONS' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_EXTENSIONS' ) && EXMACHINA_LOAD_EXTENSIONS === false )
      return;
  } // end function exmachina_load_extensions()

  /**
   * Load Admin
   *
   * Loads all the admin files for the framework. The exmachina_pre_admin
   * action hook is called before any of the files are required.
   *
   * If a child theme defines EXMACHINA_LOAD_ADMIN as false before requiring
   * this engine.php file, then this function will abort before any other admin
   * files are loaded.
   *
   * @since 0.1.0
   */
  function exmachina_load_admin() {

    /* Triggers the 'exmachina_pre_admin' action hook. */
    do_action( 'exmachina_pre_admin' );

    /* Short circuits the framework if 'EXMACHINA_LOAD_ADMIN' is defined as false. */
    if ( defined( 'EXMACHINA_LOAD_ADMIN' ) && EXMACHINA_LOAD_ADMIN === false )
      return;

    /* Check if in the WordPress admin. */
    if ( is_admin() ) {

    /* Load the theme settings page. */
    require_once( trailingslashit( EXMACHINA_ADMIN_FUNCTIONS ) . 'theme-settings.php' );

    require_once( trailingslashit( EXMACHINA_ADMIN_OPTIONS ) . 'meta-box-demo.php' );

    } // end if(is_admin())
  } // end function exmachina_load_admin()

} // end class ExMachina