<?php
/*
Plugin Name: Artikeltyp zurückgeben
*/

add_filter( 'the_content', 'mm_content_output_post_object' );

function mm_content_output_post_object( $content ) {
	return $content . sprintf( 'This article is a: %s', get_post_type() );
}