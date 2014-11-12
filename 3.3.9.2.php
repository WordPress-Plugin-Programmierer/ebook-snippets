<?php
/*
Plugin Name: the_title Filter
*/
add_filter( 'the_title', 'mm_search_title' );

function mm_search_title( $title ) {
	if ( is_search() && in_the_loop() ) {
		return 'Gefunden: ' . $title;
	}

	return $title;
}