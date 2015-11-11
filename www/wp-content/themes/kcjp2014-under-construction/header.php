<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php bloginfo( 'name' ); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
<!--[if lt IE 9]>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/html5shiv.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/respond.min.js"></script>
<![endif]-->
</head>
<body <?php body_class(); ?>>
  <div id="wrap">
  <div class="kgsNavbar navbar navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand scrollTo" href="<?php echo is_home() ? '#' : home_url(); ?>">KITCHENCAR.JP</a>
      </div>
      <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
          <li><a href="<?php if ( !is_home() ) echo home_url(); ?>#kitchencars" class="scrollTo" title="キッチンカー"><i class="fa fa-truck"></i> Kitchencars</a></li>
          <li><a href="<?php if ( !is_home() ) echo home_url(); ?>#event-summary" class="scrollTo" title="開催概要"><i class="fa fa-question"></i> About</a></li>
          <li><a href="<?php if ( !is_home() ) echo home_url(); ?>#access" class="scrollTo" title="会場アクセス"><i class="fa fa-map-marker"></i> Access</a></li>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>