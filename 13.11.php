<?php
/*
Plugin Name: Objekte eines Terms zurückgeben
*/

add_action( 'init', function () {

	$term_obj = get_term_by( 'name', 'Romane', 'genre' );

	if ( is_object( $term_obj ) ) {
		$objects = get_objects_in_term( $term_obj->term_id, 'genre' );

		var_dump( $objects );
	}

} );
