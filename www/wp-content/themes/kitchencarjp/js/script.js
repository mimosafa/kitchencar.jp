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
	    $aside   = $( '.contents-aside' ),
	    $footer  = $( '#footer' );

	var thinResizeEvent = function( callback, bool, intval ) {
		var cb = callback,
		    dofirst = bool,
		    interval = intval;
		if ( dofirst == true ) {
			cb();
		}
		if ( typeof interval === 'undefined' ) {
			interval = 100;
		}
		/**
		 * @see http://blog.tsumikiinc.com/article/20141125_javascript-event-throttle.html
		 */
		var intervaledResize = ( function() {
			var lastTime = new Date().getTime() - interval;
			return function() {
				if ( ( lastTime + interval ) <= new Date().getTime() ) {
					lastTime = new Date().getTime();
					cb();
				}
			};
		} )();

		if ( window.addEventListener ) {
			window.addEventListener( 'resize', intervaledResize, false );
		} else if ( window.attachEvent ){
			window.attachEvent( 'onresize', intervaledResize );
		}
	};

	/*
	 * Fixed Navbar Position with WordPress Adminbar
	 */
	if ( $wpadminbar.length ) {
		var navbarOffsetTop = function() {
			$navbar.css( 'top', $wpadminbar.height() );
		};
		thinResizeEvent( navbarOffsetTop, true );
	}

	/*
	 * Bootstrap Grid Column Fall
	 * @see PHP Class KCJP\View\Gene
	 */
	if ( $caption.length ) {
		var setContentsMainHeight = function() {
			/*
			 * @uses KCJP_LAYOUT
			 */
			if ( window.innerWidth > KCJP_LAYOUT.bp ) {
				$main.css( 'minHeight', $caption.height() + $aside.height() );
			} else {
				$main.css( 'minHeight', '' );
			}
		};
		thinResizeEvent( setContentsMainHeight, true );
	}

	var setFooterHeight = function() {
		var padding = $footer.height() + 40;
		$( 'body' ).css( 'marginBottom', padding );
	};
	thinResizeEvent( setFooterHeight, true );

} );
