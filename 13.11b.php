<?php
/*
Plugin Name: Objekte eines Terms zurückgeben
*/

add_action( 'init', function () {

	$romane_term_obj = get_term_by( 'name', 'Romane', 'genre' );
	$campus_term_obj = get_term_by( 'name', 'Campus', 'publisher' );

	if ( is_object( $romane_term_obj ) && is_object( $campus_term_obj ) ) {
		$objects = get_objects_in_term(
			array( $romane_term_obj->term_id, $campus_term_obj->term_id ),
			array( 'genre', 'publisher' )
		);

		var_dump( $objects );
	}

} );
