<?php
/*
Plugin Name: Add Custom Terms
*/

register_activation_hook( __FILE__, 'mm_create_terms' );

function mm_create_terms() {
	$terms = array( 'Roman', 'Krimi', 'Thriller' );

	foreach ( $terms as $term ) {
		if ( term_exists( $term, 'genre' ) ) {
			continue;
		}

		var_dump( wp_insert_term( $term, 'genre' ) );
	}
}
