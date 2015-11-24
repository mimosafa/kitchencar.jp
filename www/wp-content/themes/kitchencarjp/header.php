<?php
/**
 * Kitchencar.jp header.php
 *
 * @since 0.0.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Language" content="<?php bloginfo( 'language' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
<!--[if lt IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
<![endif]-->
</head>
<body <?php body_class(); ?>>
<?php
/**
 * Global Navigation Bar
 *
 * @since 0.0.0
 */
get_template_part( 'navbar' ); ?>
<div id="wrap">
