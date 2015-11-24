<?php
/**
 * Kitchencar.jp Global Navigation Bar
 *
 * @since 0.0.0
 */

/**
 * Brand Anchor HREF
 *
 * @var string
 */
$_brand_url = is_home() ? '#' : esc_url( home_url() );

?><div class="navbar navbar-fixed-top" id="kcjp-global-navbar">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo $_brand_url; ?>">KITCHENCAR.JP</a>
		</div><?php /*
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li><a href="#kitchencars" class="" title="キッチンカー"><i class="fa fa-truck"></i> Kitchencars</a></li>
				<li><a href="#event-summary" class="" title="開催概要"><i class="fa fa-question"></i> About</a></li>
				<li><a href="#access" class="" title="会場アクセス"><i class="fa fa-map-marker"></i> Access</a></li>
			</ul>
		</div><!--/.nav-collapse --> */ ?>
	</div>
</div>
