<?php
/*
Plugin Name: wp_title Filter
*/

add_filter( 'wp_title', 'mm_head_title', 20, 3 );

function mm_head_title( $title, $step, $seplocation ) {
	if ( is_search() ) {
		$title = 'Suche nach: ' . get_search_query() . '';
	}

	return $title;
}