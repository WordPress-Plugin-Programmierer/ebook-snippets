<?php
/*
Plugin Name: doing_filter() Funktion
*/

add_filter( 'the_content', function ( $content ) {
	// gibt 'the_content' zurück
	var_dump( current_filter() );

	// gibt true zurück
	var_dump( doing_filter( 'the_content' ) );


	return apply_filters( 'mm_my_test_filter', $content );
} );

add_filter( 'mm_my_test_filter', function ( $content ) {

	// gibt 'mm_my_test_filter' zurück
	var_dump( current_filter() );

	// gibt true zurück
	var_dump( doing_filter( 'the_content' ) );

	// gibt true zurück
	var_dump( doing_filter( 'mm_my_test_filter' ) );

	return $content;
} );