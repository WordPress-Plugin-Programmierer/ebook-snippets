<?php
/*
Plugin Name: Current Action
*/


add_action( 'wp_head', 'mm_add_something' );
add_action( 'wp_footer', 'mm_add_something' );

function mm_add_something() {
	if ( 'wp_head' == current_filter() ) {
		# Mache etwas
		return;
	}

	# Mache etwas anderes
}