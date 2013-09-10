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

    /* Add the settings defaults. */
    add_filter( 'exmachina_theme_settings_defaults', array( $this, 'setting_defaults' ) );

    /* Trigger the settings sanitizer. */
    add_action( 'exmachina_settings_sanitizer_init', array( $this, 'sanitization' ) );

    /* Add contextual help to the 'exmachina_theme_settings_help' hook. */
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
  function register_metabox() {

    add_meta_box('demo_metabox', '<i class="uk-icon-cog"></i> Demo Metabox', array( $this, 'display_metabox' ), $_exmachina_admin_theme_settings, 'normal', 'high');

    add_meta_box('form_metabox', 'Form Metabox', array( $this, 'display_form_metabox' ), $_exmachina_admin_theme_settings, 'normal', 'high');

    add_meta_box('type_metabox', 'Typography Metabox', array( $this, 'display_type_metabox' ), $_exmachina_admin_theme_settings, 'normal', 'high');

  } // end function register_metabox()

  function display_type_metabox() {
    ?>
    <div class="basic-wrap">


                    <div class="option_input typography">
                      <style class="preview-css"></style>

                      <!-- // Font Size -->
                      <input class="input_spinner font_size  ui-spinner-input" name="hor_options_body_text_typography_size" rel="size" type="text" value="15" aria-custom-max="75" aria-custom-min="1" aria-valuenow="15" autocomplete="off" role="spinbutton">

                      <!-- // Font Size Type (EM/PX/PT) -->
                      <select class=" pretty-select font_size_type" name="hor_options_body_text_typography_size_type" rel="size_type" style="display: none;">
                        <optgroup label="Size Type">
                          <option selected="">px</option>
                          <option>em</option>
                          <option>pt</option>
                        </optgroup>
                      </select>

                      <!-- // Font Name -->
                      <select class=" pretty-select font" name="hor_options_body_text_typography_font" rel="font" style="display: none;">
                        <optgroup label="Custom Fonts">
                          <option selected="">Helvetica Neue</option>
                        </optgroup>
                        <optgroup label="Basic Fonts">
                          <option>Arial</option>
                          <option>Arial Black</option>
                          <option>Comic Sans MS</option>
                          <option>Courier New</option>
                          <option>Georgia</option>
                          <option>Impact</option>
                          <option>Palatino Linotype</option>
                          <option>Lucida Console</option>
                          <option>Lucida Sans Unicode</option>
                          <option>Times New Roman</option>
                          <option>Tahoma</option>
                          <option>Trebuchet MS</option>
                          <option>Verdana</option>
                        </optgroup>
                        <optgroup label="Google Web Fonts">
                          <option>ABeeZee</option>
                          <option>Abel</option>
                          <option>Abril Fatface</option>
                          <option>Aclonica</option>
                          <option>Acme</option>
                          <option>Actor</option>
                          <option>Adamina</option>
                          <option>Advent Pro</option>
                          <option>Aguafina Script</option>
                          <option>Akronim</option>
                          <option>Aladin</option>
                          <option>Aldrich</option>
                          <option>Alef</option>
                          <option>Alegreya</option>
                          <option>Alegreya SC</option>
                          <option>Alex Brush</option>
                          <option>Alfa Slab One</option>
                          <option>Alice</option>
                          <option>Alike</option>
                          <option>Alike Angular</option>
                          <option>Yanone Kaffeesatz</option>
                          <option>Yellowtail</option>
                          <option>Yeseva One</option>
                          <option>Yesteryear</option>
                          <option>Zeyada</option>
                        </optgroup>
                      </select>

                      <!-- // Weight Type (300/400/500/700/900 | italic) -->
                      <select class=" pretty-select weight" name="hor_options_body_text_typography_weight" rel="weight" style="display: none;">
                        <optgroup label="Font Weight">
                          <option value="300">Light</option>
                          <option value="300italic">Light Italic</option>
                          <option value="regular" selected="">Regular</option>
                          <option value="italic">Italic</option>
                          <option value="700">Bold</option>
                          <option value="700italic">Bold Italic</option>
                          <option value="900">Extra Bold</option>
                          <option value="900italic">Extra Bold Italic</option>
                        </optgroup>
                      </select>

                      <!-- // Colour -->
                      <input class="colourpicker hor_options_body_text_typography minicolors-input" id="hor_options_body_text_typography" name="hor_options_body_text_typography_colour" type="text" rel="colour" value="#333333" size="7" maxlength="7">

                      <!-- // Text Transform -->
                      <select class="hor_options_body_text_typography pretty-select transform" name="hor_options_body_text_typography_transform">
                        <optgroup label="Text Transform">
                          <option value="none" selected="">None</option>
                          <option value="uppercase">Uppercase</option>
                        </optgroup>
                      </select>

                      <!-- // Text Decoration -->
                      <select class="hor_options_body_text_typography pretty-select variant" name="hor_options_body_text_typography__decoration">
                        <optgroup label="Text Decoration">
                          <option value="none" selected="">None</option>
                          <option value="underline">Underline</option>
                        </optgroup>
                      </select>

                      <div class="clear"></div>
                      <div class="font-preview" style="color:#333333;font-family:Helvetica Neue;font-size:15px;text-transform:;font-style:normal;font-weight:normal;">Sphinx of black quartz, judge my vow.</div>
                    </div>

                  <div class="clear"></div>
                  <hr class="separator mt20">

    </div>
    <?php
  } // end function display_type_metabox

  /**
   * Display Metabox
   * @return [type] [description]
   */
  function display_metabox() {
    ?>
    <div class="basic-wrap">
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
    </div>
    <?php
  } // end function display_metabox()

  /**
   * Display Metabox
   * @return [type] [description]
   */
  function display_form_metabox() {
    ?>
    <div class="basic-wrap">
    <fieldset class="uk-form uk-margin">
      <legend>Legend</legend>
      <input type="text" placeholder="Text input">
      <input type="password" placeholder="Password input">
      <select>
        <option>Option 01</option>
        <option>Option 02</option>
      </select>
      <button class="uk-button" type="submit">Button</button>
      <label><input type="checkbox"> Checkbox</label>
    </fieldset>

    <div class="uk-form uk-margin uk-grid" data-uk-grid-margin>

        <fieldset class="uk-form uk-width-medium-1-4">
          <legend>Rows</legend>
          <div class="uk-form-row">
            <input type="text" placeholder="Text input">
          </div>
          <div class="uk-form-row">
            <input type="password" placeholder="Password input">
          </div>
          <div class="uk-form-row">
            <select>
              <option>Option 01</option>
              <option>Option 02</option>
            </select>
          </div>
          <div class="uk-form-row">
            <label><input type="checkbox"> Checkbox</label>
          </div>
          <div class="uk-form-row">
            <button type="submit">Button</button>
          </div>
        </fieldset>

        <fieldset class="uk-form uk-width-medium-1-4">
          <legend>States</legend>
          <div class="uk-form-row">
            <input type="text" placeholder=":focus">
          </div>
          <div class="uk-form-row">
            <input type="text" placeholder=":disabled" disabled>
          </div>
          <div class="uk-form-row">
            <input type="text" placeholder="form-danger" class="uk-form-danger" value="form-danger">
          </div>
          <div class="uk-form-row">
            <input type="text" placeholder="form-success" class="uk-form-success" value="form-success">
          </div>
        </fieldset>

        <fieldset class="uk-form uk-width-medium-1-2">
          <legend>Sizes and styles</legend>
          <div class="uk-form-row">
            <input type="text" placeholder="form-large" class="uk-form-large">
            <select class="uk-form-large">
              <option>Option 01</option>
              <option>Option 02</option>
            </select>
            <button class="uk-button uk-button-large">Button</button>
          </div>
          <div class="uk-form-row">
            <input type="text" placeholder="Default">
            <select>
              <option>Option 01</option>
              <option>Option 02</option>
            </select>
            <button class="uk-button">Button</button>
          </div>
          <div class="uk-form-row">
            <input type="text" placeholder="form-small" class="uk-form-small">
            <select class="uk-form-small">
              <option>Option 01</option>
              <option>Option 02</option>
            </select>
            <button class="uk-button uk-button-small">Button</button>
          </div>
          <div class="uk-form-row">
            <input type="text" placeholder="form-blank" class="uk-form-blank">
          </div>
        </fieldset>

      </div>

      <fieldset class="uk-form uk-margin">
          <legend>Widths</legend>
          <div class="uk-form-row">
            <input type="text" placeholder="form-width-large" class="uk-form-width-large">
            <input type="text" placeholder="form-width-medium" class="uk-form-width-medium">
            <input type="text" placeholder="form-width-small" class="uk-form-width-small">
            <input type="text" placeholder="form-width-mini" class="uk-form-width-mini">
          </div>
          <div class="uk-form-row">
            <select class="uk-form-width-large">
              <option>form-width-large</option>
            </select>
            <select class="uk-form-width-medium">
              <option>form-width-medium</option>
            </select>
            <select class="uk-form-width-small">
              <option>form-width-small</option>
            </select>
            <select class="uk-form-width-mini">
              <option>form-width-mini</option>
            </select>
          </div>
          <div class="uk-form-row">
            <textarea cols="30" rows="1" placeholder="form-width-large" class="uk-form-width-large"></textarea>
            <textarea cols="30" rows="1" placeholder="form-width-medium" class="uk-form-width-medium"></textarea>
            <textarea cols="30" rows="1" placeholder="form-width-small" class="uk-form-width-small"></textarea>
          </div>
          <div class="uk-form-row">
            <input type="text" placeholder="width-100" class="uk-width-1-1">
          </div>
          <div class="uk-form-row">
            <select class="uk-width-1-1">
              <option>width-100</option>
            </select>
          </div>
          <div class="uk-form-row">
            <textarea cols="30" rows="1" placeholder="width-100" class="uk-width-1-1"></textarea>
          </div>
        </fieldset>

        <fieldset class="uk-form uk-margin uk-form-stacked">
          <legend>Form stacked</legend>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-s-it">Text input</label>
            <div class="uk-form-controls">
              <input type="text" id="form-s-it" placeholder="Text input"> <span class="uk-form-help-inline">Add the class <code>.uk-form-help-inline</code> for inline help text.</span>
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-s-ip">Password input</label>
            <div class="uk-form-controls">
              <input type="password" id="form-s-ip" placeholder="Password input">
            </div>
          </div>

          <div class="uk-form-row">
            <label class="uk-form-label" for="form-s-s">Select field</label>
            <div class="uk-form-controls">
              <select id="form-s-s">
                <option>Option 01</option>
                <option>Option 02</option>
              </select>
            </div>
          </div>

          <div class="uk-form-row">
            <label class="uk-form-label" for="form-s-t">Textarea</label>
            <div class="uk-form-controls">
              <textarea id="form-s-t" cols="30" rows="5" placeholder="Textarea text"></textarea>
              <p class="uk-form-help-block">Add the class <code>.uk-form-help-block</code> for help text in block elements.</p>
            </div>
          </div>
          <div class="uk-form-row">
            <span class="uk-form-label">Radio input</span>
            <div class="uk-form-controls">
              <input type="radio" id="form-s-r" name="radio"> <label for="form-s-r">Radio input</label><br>
              <input type="radio" id="form-s-r1" name="radio"> <label for="form-s-r1">1</label>
              <label><input type="radio" name="radio"> 2</label>
              <label><input type="radio" name="radio"> 3</label>
            </div>
          </div>
          <div class="uk-form-row">
            <span class="uk-form-label">Checkbox input</span>
            <div class="uk-form-controls">
              <input type="checkbox" id="form-s-c"> <label for="form-s-c">Checkbox input</label><br>
              <input type="checkbox" id="form-s-c1"> <label for="form-s-c1">1</label>
              <label><input type="checkbox"> 2</label>
              <label><input type="checkbox"> 3</label>
            </div>
          </div>

          <div class="uk-form-row">
            <span class="uk-form-label">Mixed controls</span>
            <div class="uk-form-controls">
              <p class="uk-form-controls-condensed">
                <input type="checkbox" id="form-s-mix1"> <label for="form-s-mix1">Checkbox input</label>
                <input type="number" id="form-s-mix2" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-s-mix2">Number input</label>
                <select id="form-s-mix3" class="uk-form-small">
                  <option selected="selected">Option 01</option>
                  <option>Option 02</option>
                </select>
                <label for="form-s-mix3">Select field</label>
              </p>
              <p class="uk-form-controls-condensed">
                <label><input type="checkbox"> Checkbox input</label>
                <label><input type="number" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> Number input</label>
                <label>
                  <select class="uk-form-small">
                    <option selected="selected">Option 01</option>
                    <option>Option 02</option>
                  </select>
                  Select field
                </label>
              </p>
            </div>
          </div>
        </fieldset>

        <fieldset class="uk-form uk-margin uk-form-horizontal">
          <legend>Form horizontal</legend>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-it">Text input</label>
            <div class="uk-form-controls">
              <input type="text" id="form-h-it" placeholder="Text input"> <span class="uk-form-help-inline">Add the class <code>.uk-form-help-inline</code> for inline help text.</span>
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-ip">Password input</label>
            <div class="uk-form-controls">
              <input type="password" id="form-h-ip" placeholder="Password input">
            </div>
          </div>

          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-ie">Email input</label>
            <div class="uk-form-controls">
              <input type="email" id="form-h-ie" placeholder="name@domain.com">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-is">Search input</label>
            <div class="uk-form-controls">
              <input type="search" id="form-h-is" placeholder="Search...">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-ite">Tel input</label>
            <div class="uk-form-controls">
              <input type="tel" id="form-h-ite" placeholder="+49 555 123456">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-iu">URL input</label>
            <div class="uk-form-controls">
              <input type="url" id="form-h-iu" placeholder="http://">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-if">File input</label>
            <div class="uk-form-controls">
              <input type="file" id="form-h-if">
            </div>
          </div>

          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-s">Select field</label>
            <div class="uk-form-controls">
              <select id="form-h-s">
                <option>Option 01</option>
                <option>Option 02</option>
              </select>
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-sm">Select field</label>
            <div class="uk-form-controls">
              <select id="form-h-sm" multiple="multiple">
                <option>Option 01</option>
                <option>Option 02</option>
                <option>Option 03</option>
                <option>Option 04</option>
              </select>
            </div>
          </div>

          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-t">Textarea</label>
            <div class="uk-form-controls">
              <textarea id="form-h-t" cols="30" rows="5" placeholder="Textarea text"></textarea>
              <p class="uk-form-help-block">Add the class <code>.uk-form-help-block</code> for help text in block elements.</p>
            </div>
          </div>

          <div class="uk-form-row">
            <span class="uk-form-label">Radio input</span>
            <div class="uk-form-controls uk-form-controls-text">
              <input type="radio" id="form-h-r" name="radio"> <label for="form-h-r">Radio input</label><br>
              <input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">1</label>
              <label><input type="radio" name="radio"> 2</label>
              <label><input type="radio" name="radio"> 3</label>
            </div>
          </div>
          <div class="uk-form-row">
            <span class="uk-form-label">Checkbox input</span>
            <div class="uk-form-controls uk-form-controls-text">
              <input type="checkbox" id="form-h-c"> <label for="form-h-c">Checkbox input</label><br>
              <input type="checkbox" id="form-h-c1"> <label for="form-h-c1">1</label>
              <label><input type="checkbox"> 2</label>
              <label><input type="checkbox"> 3</label>
            </div>
          </div>

          <div class="uk-form-row">
            <span class="uk-form-label">Mixed controls</span>
            <div class="uk-form-controls uk-form-controls-text">
              <p class="uk-form-controls-condensed">
                <input type="checkbox" id="form-h-mix1"> <label for="form-h-mix1">Checkbox input</label>
                <input type="number" id="form-h-mix2" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-h-mix2">Number input</label>
                <select id="form-h-mix3" class="uk-form-small">
                  <option selected="selected">Option 01</option>
                  <option>Option 02</option>
                </select>
                <label for="form-h-mix3">Select field</label>
              </p>
              <p class="uk-form-controls-condensed">
                <label><input type="checkbox"> Checkbox input</label>
                <label><input type="number" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> Number input</label>
                <label>
                  <select class="uk-form-small">
                    <option selected="selected">Option 01</option>
                    <option>Option 02</option>
                  </select>
                  Select field
                </label>
              </p>
            </div>
          </div>

          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-ic">Color input</label>
            <div class="uk-form-controls">
              <input type="color" id="form-h-ic" placeholder="#000000">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-in">Number input</label>
            <div class="uk-form-controls">
              <input type="number" id="form-h-in" min="0" max="10" value="5">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-ir">Range input</label>
            <div class="uk-form-controls">
              <input type="range" id="form-h-ir" value="10">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-id">Date input</label>
            <div class="uk-form-controls">
              <input type="date" id="form-h-id" placeholder="1970-01-01">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-im">Month input</label>
            <div class="uk-form-controls">
              <input type="month" id="form-h-im" placeholder="1970-01">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-iw">Week input</label>
            <div class="uk-form-controls">
              <input type="week" id="form-h-iw" placeholder="1970-W01">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-iti">Time input</label>
            <div class="uk-form-controls">
              <input type="time" id="form-h-iti" placeholder="00:00:00">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-idt">Datetime input</label>
            <div class="uk-form-controls">
              <input type="datetime" id="form-h-idt" placeholder="1970-01-01T00:00:00Z">
            </div>
          </div>
          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-idtl">Datetime-local input</label>
            <div class="uk-form-controls">
              <input type="datetime-local" id="form-h-idtl" placeholder="1970-01-01T00:00">
            </div>
          </div>

          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-it">Disabled input</label>
            <div class="uk-form-controls">
              <input type="text" id="form-h-itd" placeholder="Text input" disabled>
            </div>
          </div>

          <div class="uk-form-row">
            <label class="uk-form-label" for="form-h-it">Required input</label>
            <div class="uk-form-controls">
              <input type="text" id="form-h-itr" placeholder="Text input" required>
            </div>
          </div>

          <div class="uk-form-row">
            <span class="uk-form-label">Input buttons</span>
            <div class="uk-form-controls">
              <input type="reset" value="Reset">
              <input type="button" value="Button">
              <input type="submit" value="Submit">
              <input type="submit" value="Disabled" disabled>
            </div>
          </div>

          <div class="uk-form-row">
            <span class="uk-form-label">Buttons</span>
            <div class="uk-form-controls">
              <button type="reset">Reset</button>
              <button type="button">Button</button>
              <button type="submit">Submit</button>
              <button type="submit" disabled>Disabled</button>
            </div>
          </div>
        </fieldset>

        <fieldset class="uk-form uk-margin">
          <legend>Form grid</legend>

          <div class="uk-grid">
            <div class="uk-width-1-1">
              <input type="text" placeholder="100" class="uk-width-1-1">
            </div>
          </div>

          <div class="uk-grid">
            <div class="uk-width-1-2"><input type="text" placeholder="50" class="uk-width-1-1"></div>
            <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
            <div class="uk-width-1-4"><input type="text" placeholder="25" class="uk-width-1-1"></div>
          </div>

          <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-2">
              <label for="form-g-a">Label</label>
              <div class="uk-form-controls">
                <input type="text" id="form-g-a" placeholder="50" class="uk-width-1-1">
              </div>
            </div>
            <div class="uk-width-medium-1-2">
              <label for="form-g-b">Label</label>
              <div class="uk-form-controls">
                <input type="text" id="form-g-b" placeholder="50" class="uk-width-1-1">
              </div>
            </div>
          </div>
        </fieldset>

        <fieldset class="uk-form uk-margin uk-form-stacked">
          <legend>Form stacked grid</legend>

          <div class="uk-grid">
            <div class="uk-width-1-1">
              <label class="uk-form-label" for="form-gs-street">Address</label>
              <div class="uk-form-controls">
                <input type="text" id="form-gs-street" placeholder="Street" class="uk-width-1-1">
              </div>
            </div>
          </div>

          <div class="uk-grid">
            <div class="uk-width-1-2"><input type="text" placeholder="City" class="uk-width-1-1"></div>
            <div class="uk-width-1-4"><input type="text" placeholder="State" class="uk-width-1-1"></div>
            <div class="uk-width-1-4"><input type="text" placeholder="ZIP" class="uk-width-1-1"></div>
          </div>

          <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-2">
              <label class="uk-form-label" for="form-gs-a">Label</label>
              <div class="uk-form-controls">
                <input type="text" id="form-gs-a" placeholder="50" class="uk-width-1-1">
              </div>
            </div>
            <div class="uk-width-medium-1-2">
              <label class="uk-form-label" for="form-gs-b">Label</label>
              <div class="uk-form-controls">
                <input type="text" id="form-gs-b" placeholder="50" class="uk-width-1-1">
              </div>
            </div>
          </div>
        </fieldset>

         <!-- Begin Markup -->
        <fieldset class="uk-form uk-form-horizontal">

                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="form-h-it">Text input</label>
                                    <div class="uk-form-controls">
                                        <input type="text" id="form-h-it" placeholder="Text input">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="form-h-ip">Password input</label>
                                    <div class="uk-form-controls">
                                        <input type="password" id="form-h-ip" placeholder="Password input">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="form-h-s">Select field</label>
                                    <div class="uk-form-controls">
                                        <select id="form-h-s">
                                            <option>Option 01</option>
                                            <option>Option 02</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label class="uk-form-label" for="form-h-t">Textarea</label>
                                    <div class="uk-form-controls">
                                        <textarea id="form-h-t" cols="30" rows="5" placeholder="Textarea text"></textarea>
                                    </div>
                                </div>

                                <div class="uk-form-row">
                                    <span class="uk-form-label">Radio input</span>
                                    <div class="uk-form-controls uk-form-controls-text">
                                        <input type="radio" id="form-h-r" name="radio"> <label for="form-h-r">Radio input</label><br>
                                        <input type="radio" id="form-h-r1" name="radio"> <label for="form-h-r1">1</label>
                                        <label><input type="radio" name="radio"> 2</label>
                                        <label><input type="radio" name="radio"> 3</label>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <span class="uk-form-label">Checkbox input</span>
                                    <div class="uk-form-controls uk-form-controls-text">
                                        <input type="checkbox" id="form-h-c"> <label for="form-h-c">Checkbox input</label><br>
                                        <input type="checkbox" id="form-h-c1"> <label for="form-h-c1">1</label>
                                        <label><input type="checkbox"> 2</label>
                                        <label><input type="checkbox"> 3</label>
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <span class="uk-form-label">Mixed controls</span>
                                    <div class="uk-form-controls uk-form-controls-text">
                                        <input type="checkbox" id="form-h-mix4"> <label for="form-h-mix4">Checkbox input</label>
                                        <input type="number" id="form-h-mix5" min="0" max="10" value="5" class="uk-form-width-mini uk-form-small"> <label for="form-h-mix5">Number input</label>
                                        <select id="form-h-mix6" class="uk-form-small">
                                            <option selected="selected">Option 01</option>
                                            <option>Option 02</option>
                                        </select>
                                        <label for="form-h-mix6">Select field</label>
                                    </div>
                                </div>

                                <div class="uk-form-row">
                                    <span class="uk-form-label">Select Toggles</span>
                                    <div class="uk-form-controls uk-form-controls-text">
                                        <label class="switch">
      <input type="checkbox" class="switch-input">
      <span class="switch-label" data-on="On" data-off="Off"></span>
      <span class="switch-handle"></span>
    </label>

    <label class="switch">
      <input type="checkbox" class="switch-input" checked>
      <span class="switch-label" data-on="On" data-off="Off"></span>
      <span class="switch-handle"></span>
    </label>

    <label class="switch switch-green">
      <input type="checkbox" class="switch-input" checked>
      <span class="switch-label" data-on="On" data-off="Off"></span>
      <span class="switch-handle"></span>
    </label>
                                    </div>
                                </div>

                                <div class="uk-form-row">
                                    <span class="uk-form-label">Fancy Dropdowns</span>
                                    <div class="uk-form-controls uk-form-controls-text">
                                        <div class="dropdown">
      <select name="one" class="dropdown-select">
        <option value="">Select…</option>
        <option value="1">Option #1</option>
        <option value="2">Option #2</option>
        <option value="3">Option #3</option>
      </select>
    </div>
    <div class="dropdown dropdown-dark">
      <select name="two" class="dropdown-select">
        <option value="">Select…</option>
        <option value="1">Option #1</option>
        <option value="2">Option #2</option>
        <option value="3">Option #3</option>
      </select>
    </div>
                                    </div>
                                </div>

                            </fieldset>
                            </div>
        <!-- End Markup -->
    <?php
  } // end function display_form_metabox()

} // end class ExMachina_Demo_Metabox

new ExMachina_Demo_Metabox;

