<?php
/*
Plugin Name: Registrierte Taxonomien zurückgeben
*/


add_action( 'wp_loaded', 'mm_output_taxonomies' );

function mm_output_taxonomies() {
	// 1
	var_dump( get_taxonomies() );

	// 2
	var_dump( get_taxonomies( array(
		'public' => false
	) ) );

	// 3
	var_dump(
		get_taxonomies( array( 'show_ui' => true ) )
	);

	// 4
	var_dump(
		get_taxonomies( array(
			'hierarchical'      => true,
			'show_in_nav_menus' => true
		),
			'names',
			'or'
		)
	);

	// 5
	var_dump(
		get_taxonomies(
			array( 'name' => 'post_tag' ),
			'objects'
		)
	);
}