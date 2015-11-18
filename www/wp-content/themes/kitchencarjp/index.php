<?php
/**
 * Kitchencar.jp Theme index.php
 *
 * @since 0.0.0
 */

/**
 * Cache Queried Object
 *
 * @var null|Object
 */
$_queried = get_queried_object();

/**
 * Context for Viws
 *
 * @var string
 */
$_context = apply_filters( 'kcjp_view_context', '', $_queried );

/**
 * @var boolean
 */
$_use_glid_system          = apply_filters( 'kcjp_use_glid_system',          true,  $_queried );
$_has_contents_information = apply_filters( 'kcjp_has_contents_information', false, $_queried ) && $_use_glid_system;
$_show_contents_aside      = apply_filters( 'kcjp_show_contents_aside',      true,  $_queried ) && $_use_glid_system;

/**
 * @var string
 */
$_contents_class       = apply_filters( 'kcjp_contents_class',       'container' );
$_contents_main_class  = apply_filters( 'kcjp_contents_main_class',  'col-md-8'  );
$_contents_aside_class = apply_filters( 'kcjp_contents_aside_class', 'col-md-4'  );

get_header( $_context );

do_action( 'kcjp_lead_contents', $_queried ); ?>

<div class="<?php esc_attr_e( $_contents_class ); ?>" id="kcjp-contents">
	<?php if ( $_use_glid_system ) { ?><div class="row"><?php } ?>
		<?php if ( $_has_contents_information ) { ?><section class="col-md-4 pull-right" id="kcjp-contents-information">
			<?php do_action( 'kcjp_contents_information', $_queried ); ?>
		</section><?php } ?>
		<div class="<?php esc_attr_e( $_contents_main_class ); ?>" id="kcjp-contents-main">
			<?php get_template_part( 'loop', $_context ); ?>
		</div>
		<?php if ( $_show_contents_aside ) { ?><aside class="<?php esc_attr_e( $_contents_aside_class ); ?>" id="kcjp-contents-aside">
			<?php get_sidebar(); ?>
		</aside><?php } ?>
	<?php if ( $_use_glid_system ) { ?></div><?php } ?>
</div>

<?php

get_footer( $_context );
