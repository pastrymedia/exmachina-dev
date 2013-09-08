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
    define( 'EXMACHINA_OPTIONS', trailingslashit( EXMACHINA_DIR ) . 'options' );
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

} // end class ExMachina