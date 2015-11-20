/*
 * Kitchencar.jp Javascripts
 * @since  0.0.0
 * @global KCJP_LAYOUT
 */

jQuery( function( $ ) {

	var $navbar = $( '#kcjp-global-navbar' ),
	    $wpadminbar = $( '#wpadminbar' );

	var $caption = $( '.contents-caption' ),
	    $main    = $( '.contents-main' ),
	    $aside   = $( '.contents-aside' );

	/*
	 * Fixed Navbar Position with WordPress Adminbar
	 */
	if ( $wpadminbar.length ) {
		var navbarOffsetTop = function() {
			$navbar.css( 'top', $wpadminbar.height() + 'px' );
		};
		navbarOffsetTop();
		/**
		 * @see http://blog.tsumikiinc.com/article/20141125_javascript-event-throttle.html
		 */
		var navbarResized = ( function() {
			var interval = 100;
			var lastTime = new Date().getTime() - interval;
			return function() {
				if ( ( lastTime + interval ) <= new Date().getTime() ) {
					lastTime = new Date().getTime();
					navbarOffsetTop();
				}
			};
		} )();
		if ( window.addEventListener ) {
			window.addEventListener( 'resize', navbarResized, false );
		} else if ( window.attachEvent ){
			window.attachEvent( 'onresize', navbarResized );
		}
	}

	/*
	 * Bootstrap Grid Column Fall
	 * @see PHP Class KCJP\View\Gene
	 */
	if ( $caption.length ) {
		var setHeight = function() {
			/*
			 * @uses KCJP_LAYOUT
			 */
			if ( window.innerWidth > KCJP_LAYOUT.bp ) {
				$main.css( 'minHeight', $caption.height() + $aside.height() );
			} else {
				$main.css( 'minHeight', '' );
			}
		};
		setHeight();
		var allocationEvent = ( function() {
			var interval = 100,
			    lastTime = new Date().getTime() - interval;
			return function() {
				if ( ( lastTime + interval ) <= new Date().getTime() ) {
					lastTime = new Date().getTime();
					setHeight();
				}
			};
		} )();
		if ( window.addEventListener ) {
			window.addEventListener( 'resize', allocationEvent, false );
		} else if ( window.attachEvent ){
			window.attachEvent( 'onresize', allocationEvent );
		}
	}

} );
