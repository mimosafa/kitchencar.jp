<?php
/**
 * Kitchencar.jp Theme
 *
 * @since 0.0.0
 */

get_header();

/**
 * Home
 */
if ( is_home() ) {
	/**
	 *
	 */
	kcjp_lead_contents();
}

$specificInfo = '';
$mainClass = '';
if ( kcjp_has_specific_page_info() ) {
	$specificInfo .= "\t\t" . '<div class="col-md-4 pull-right" id="kcjp-page-info" style="height:200px; background-color: #eee">';
	$specificInfo .= kcjp_specific_page_info();
	$specificInfo .= "\t\t" . '</div>';
	$mainClass .= ' pull-left';
}

?>
<div class="container" id="contents">
	<div class="row">
		<?php echo $specificInfo; ?>
		<div class="col-md-8<?php echo $mainClass; ?>" id="kcjp-main">
			<?php get_template_part( 'loop' ); ?>
		</div>
		<div class="col-md-4 pull-right" id="kcjp-side">
			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php
get_footer();
