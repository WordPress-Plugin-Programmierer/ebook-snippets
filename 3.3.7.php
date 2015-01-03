<?php
/*
Plugin Name: current_filter() Funktion
*/

add_filter( 'the_content', 'mm_filter_content' );
add_filter( 'the_excerpt', 'mm_filter_content' );

function mm_filter_content( $content ) {
	if ( 'the_content' == current_filter() ) {
	// Mache etwas, um den Inhalt zu verändern
		return $content;
	}

	// Mache etwas anderes, um den Excerpt zu verändern
	return $content;
}