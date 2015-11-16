/*
 * Kitchencar.jp Javascripts
 * @since 0.0.0
 */

jQuery( function( $ ) {

	var $navbar = $( '#kcjp-global-navbar' );

	/**
	 * Fixed Navbar Position with WordPress Adminbar
	 */
	var $wpadminbar = $( '#wpadminbar' );
	if ( $wpadminbar.length ) {
		var navbarTop = function() {
			var adminbar = $( '#wpadminbar' );
			$navbar.css( 'top', adminbar.height() + 'px' );
		};
		navbarTop();
		/**
		 * @see http://blog.tsumikiinc.com/article/20141125_javascript-event-throttle.html
		 */
		var navbarResized = ( function() {
			var interval = 300;
			var lastTime = new Date().getTime() - interval;
			return function() {
				if ( ( lastTime + interval ) <= new Date().getTime() ) {
					lastTime = new Date().getTime();
					navbarTop();
				}
			};
		} )();
		if ( window.addEventListener ) {
			window.addEventListener( 'resize', navbarResized, false );
		} else if ( window.attachEvent ){
			window.attachEvent( 'onresize', navbarResized );
		}
	}

} );
