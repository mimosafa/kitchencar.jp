<?php

/**
 * The main template file
 */

$themeName = wp_get_theme() -> Name;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8">
  <title><?php ?></title>
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <h1><small>You're site's name is</small> <?php bloginfo( 'name' ); ?></h1>
  <p>Thank you for using &quot;<?php esc_html_e( $themeName ); ?>&quot; theme !</p>
  <p>But, this is not optimized for displaying @front-end. Please use child theme that core supported.</p>
  <?php wp_footer(); ?>
</body>
</html>
