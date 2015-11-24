<?php
/**
 * Kitchencar.jp sidebar.php
 *
 * @since 0.0.0
 */
if ( function_exists( 'dynamic_sidebar' ) && dynamic_sidebar() ) : else : ?>
<div id="access">
<h3><i class="fa fa-map-marker"></i> 会場までのアクセス</h2>
	<div class="thumbnail">
		<div class="caption">
			<p class="h4"><i class="fa fa-arrow-right"></i> 埼玉高速鉄道をご利用ください</p>
		</div>
		<img src="<?= get_stylesheet_directory_uri() ?>/images/Access_RailWay.png">
		<p>※○ の中の数字は浦和美園駅までのおおよその所要時間(分)です。乗り換え時間は含まれません。また、実際の所要時間と前後することがあります。</p>
	</div>
	<div class="thumbnail">
		<div class="caption">
			<p class="h5"><i class="fa fa-arrow-right"></i> 埼玉高速鉄道「浦和美園駅」から徒歩15分</p>
		</div>
		<img src="<?= get_stylesheet_directory_uri() ?>/images/Access_WalkWay.png">
		<p>※駐車台数に限りがありますので、公共交通機関にてご来場ください。なお、満車の際はご容赦ください。</p>
	</div>
</div>
<?php endif;
