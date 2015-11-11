<?php

namespace entrylist;

\add_filter( 'template_include', 'entrylist\\template_include' );

function template_include( $template ) {
	$_template = __DIR__ . '/index.php';
	if ( file_exists( $_template ) ) {
		$template = $_template;
	}
	return $template;
}
