<?php
/*
Plugin Name: Doing Action
*/


add_action( 'wp_footer', function ( $content ) {
	// gibt 'wp_footer' zurück
	var_dump( current_action() );

	// gibt true zurück
	var_dump( doing_action( 'wp_footer' ) );

	do_action( 'mm_my_test_function' );

} );

add_action( 'mm_my_test_function', function ( $content ) {

	// gibt 'mm_my_test_function' zurück
	var_dump( current_action() );

	// gibt true zurück
	var_dump( doing_action( 'wp_footer' ) );

	// gibt true zurück
	var_dump( doing_action( 'mm_my_test_function' ) );

	return $content;
} );