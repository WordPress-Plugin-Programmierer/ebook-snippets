<?php
/*
Plugin Name: Registrierte Artikeltypen zurückgeben
*/

add_action( 'wp_loaded', 'mm_output_post_types' );

function mm_output_post_types() {
	// 1
	var_dump( get_post_types() );

	// 2
	var_dump( get_post_types( array(
		'publicly_queryable' => true
	) ) );

	// 3
	var_dump(
		get_post_types( array( 'show_ui' => true ) )
	);

	// 4
	var_dump(
		get_post_types( array(
			'public'              => true,
			'exclude_from_search' => true
		),
			'names',
			'or'
		)
	);

	// 5
	var_dump(
		get_post_types(
			array( 'name' => 'revision' ),
			'objects'
		)
	);
}