<?php
/**
 * The template for displaying the header.
 *
 * @package ExMachina
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title>ExMachina Framework</title>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
    <div class="page">