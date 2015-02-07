<?php
/*
Plugin Name: Term-Überprüfung
*/

$term_exists = term_exists( 'Roman', 'category' );

if ( isset( $term_exists['term_id'] ) ) {
	$term = get_term( $term_exists['term_id'], 'category' );
	var_dump( $term );
}
