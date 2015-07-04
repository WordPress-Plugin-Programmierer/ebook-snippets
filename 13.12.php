<?php
/*
Plugin Name: Vor- und Nachfahren eiens Terms überprüfen
*/

add_action( 'init', function () {

	$sachbuecher_term    = get_term_by( 'name', 'Sachbücher', 'genre' );
	$programmierung_term = get_term_by( 'name', 'Programmierung', 'genre' );


	if ( term_is_ancestor_of( $sachbuecher_term, $programmierung_term, 'genre' ) ) {
		# mache etwas wenn "Programmierung" ein Kind-Element des Terms "Sachbücher" ist
	}

} );
