<?php
/*
Plugin Name: Add Custom Terms
*/

register_activation_hook( __FILE__, 'mm_create_terms' );

function mm_create_terms() {
	$terms = array( 'Roman', 'Krimi', 'Thriller' );

	foreach ( $terms as $term ) {
		if ( term_exists( $term, 'category' ) ) {
			error_log( sprintf( 'Term %s existiert bereits und wird nicht mehr angelegt.', $term ) );
			continue;
		}

		$inserted = wp_insert_term( $term, 'category' );

		if ( is_wp_error( $inserted ) ) {
			error_log( $inserted->get_error_message() );
			continue;
		}

		error_log(
			sprintf(
				'Dem Term %s wurde die ID %d zugewiesen und zur Taxonomie mit der ID %d hinzugefügt.',
				$term,
				$inserted['term_id'],
				$inserted['term_taxonomy_id']
			)
		);
	}
}
