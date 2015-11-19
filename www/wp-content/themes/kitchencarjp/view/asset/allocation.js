/**
 * @since 0.0.0
 */
jQuery( function( $ ) {

	var $caption = $( '.contents-caption' ),
	    $main    = $( '.contents-main' ),
	    $aside   = $( '.contents-aside' );

	if ( $caption.length ) {

		var contentsMainHeight = function() {
			if ( window.innerWidth > 991 ) {
				$main.css( 'minHeight', $caption.height() + $aside.height() );
			} else {
				$main.css( 'minHeight', '' );
			}
		};
		contentsMainHeight();

		var contentsMainHeightEvent = ( function() {
			var interval = 100,
			    lastTime = new Date().getTime() - interval;
			return function() {
				if ( ( lastTime + interval ) <= new Date().getTime() ) {
					lastTime = new Date().getTime();
					contentsMainHeight();
				}
			};
		} )();

		if ( window.addEventListener ) {
			window.addEventListener( 'resize', contentsMainHeightEvent, false );
		} else if ( window.attachEvent ){
			window.attachEvent( 'onresize', contentsMainHeightEvent );
		}

	}

} );
