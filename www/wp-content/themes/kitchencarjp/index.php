<?php
/**
 * Kitchencar.jp Theme index.php
 *
 * @since 0.0.0
 *
 * @uses KCJP\View\Allocation
 */

/**
 * Layout Controller
 *
 * @since 0.0.0
 *
 * @uses KCJP\View\Allocation
 */
$layout = KCJP\View\Allocation::getInstance();

get_header( $layout->context() );

/**
 * Render Lead Contents, If Exists
 */
$layout->render_lead_contents(); ?>

<div class="<?php $layout->e_class( 'container' ); ?>" id="kcjp-contents">
	<?php if ( $layout->use_grid() ) { ?><div class="row"><?php } ?>
		<?php if ( $layout->has_caption() ) { ?><section class="<?php $layout->e_class( 'caption' ); ?>" id="kcjp-contents-information">
			<?php $layout->render_caption(); ?>
		</section><?php } ?>
		<div class="<?php $layout->e_class( 'main' ); ?>" id="kcjp-contents-main">
			<?php get_template_part( 'loop', $layout->context() ); ?>
		</div>
		<?php if ( $layout->show_aside() ) { ?><aside class="<?php $layout->e_class( 'aside' ); ?>" id="kcjp-contents-aside">
			<?php get_sidebar(); ?>
		</aside><?php } ?>
	<?php if ( $layout->use_grid() ) { ?></div><?php } ?>
</div>

<?php

get_footer( $layout->context() );
