<?php
/*
Plugin Name: Artikeltyp zurückgeben
*/

add_filter( 'the_content', 'mm_content_output_post_object' );

function mm_content_output_post_object( $content ) {

	$labels = get_post_type_labels( get_post_type_object( get_post_type() ) );

	return $content . sprintf( 'This article is a: %s', $labels->name );
}