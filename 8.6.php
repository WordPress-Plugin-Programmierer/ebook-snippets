<?php
/*
Plugin Name: Inhalte auf Shortcode prüfen
*/

add_filter( 'the_content', function ( $content ) {
	if ( has_shortcode( $content, 'mm_current_date_time' ) ) {
		// mache dies
	} else {
		// mache etwas anderes
	}

	return $content;
} );
