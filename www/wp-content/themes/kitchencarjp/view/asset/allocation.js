/**
 * @since 0.0.0
 */
jQuery( function( $ ) {

	var $caption = $( '.contents-caption' ),
	    $main    = $( '.contents-main' ),
	    $aside   = $( '.contents-aside' );

	if ( $caption.length ) {

		var setHeight = function() {
			if ( window.innerWidth > 991 ) {
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
