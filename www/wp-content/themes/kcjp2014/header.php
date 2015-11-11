<?php

$_uri = is_home() ? '' : home_url();
$_anchor_class = is_home() ? 'scrollTo' : '';

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= wp_title( ' | ', true, 'right' ) . get_bloginfo( 'name' ) . ' | Kitchencar.jp'; ?></title>
<?php wp_head(); ?>
<!--[if lt IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.js"></script>
<![endif]-->
</head>
<body <?php body_class(); ?> itemscope itemtype="http://schema.org/FoodEvent">
  <div id="wrap">
    <div class="navbar navbar-fixed-top" id="kcjp-global-navbar">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand <?= $_anchor_class ?>" href="<?= $_uri ?>#">KITCHENCAR.JP</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?= $_uri ?>#kitchencars" class="<?= $_anchor_class ?>" title="キッチンカー"><i class="fa fa-truck"></i> Kitchencars</a></li>
            <li><a href="<?= $_uri ?>#event-summary" class="<?= $_anchor_class ?>" title="開催概要"><i class="fa fa-question"></i> About</a></li>
            <li><a href="<?= $_uri ?>#access" class="<?= $_anchor_class ?>" title="会場アクセス"><i class="fa fa-map-marker"></i> Access</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
