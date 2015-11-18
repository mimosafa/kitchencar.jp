<?php
/**
 * Google Analytics
 *
 * @since 0.0.0
 */
function kcjp_google_analytics_tracking_code() {
	if ( is_user_logged_in() ) {
		return;
	}
	if ( $_SERVER['HTTP_HOST'] === 'kitchencar.dev' ) {
		return;
	}
	$code = 'UA-26079619-1';
	echo <<<EOF
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', '{$code}', 'w-tokyodo.com');
  ga('send', 'pageview');
</script>
EOF;
}
add_action( 'wp_footer', 'kcjp_google_analytics_tracking_code' );
