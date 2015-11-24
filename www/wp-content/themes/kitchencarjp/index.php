<?php
/**
 * Kitchencar.jp Theme index.php
 *
 * @since 0.0.0
 */

/**
 * Layout Controller
 *
 * @since 0.0.0
 *
 * @uses KCJP\View\Gene
 */
$view = KCJP\View\Gene::getInstance();
// $view::add_caption( function( $obj ) { echo '<h2>Test</h2>'; var_dump( $obj ); } );

get_header( $view::context() );

/**
 * Render Lead Contents, If Exists
 */
$view::render_lead_contents(); ?>

<div class="<?php $view::e_class( 'container' ); ?>" id="contents-container">
	<?php if ( $view::use_grid() ) { ?><div class="<?php $view::e_class( 'row' ); ?>"><?php } ?>
		<?php if ( $view::has_caption() ) { ?><section class="<?php $view::e_class( 'caption' ); ?>" id="contents-caption">
			<?php $view::render_caption(); ?>
		</section><?php } ?>
		<div class="<?php $view::e_class( 'main' ); ?>" id="contents-main">
			<?php get_template_part( 'loop', $view::context() ); ?>
		</div>
		<?php if ( $view::show_aside() ) { ?><aside class="<?php $view::e_class( 'aside' ); ?>" id="contents-aside">
			<?php get_sidebar( $view::context() ); ?>
		</aside><?php } ?>
	<?php if ( $view::use_grid() ) { ?></div><?php } ?>
</div>

<?php

get_footer( $view::context() );
