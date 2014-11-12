<?php
/*
Plugin Name: Has Action
*/


remove_action( 'wp_head', 'wp_generator', 10 );
add_action( 'wp_head', 'wp_generator', 0 );

$is_added = has_action( 'wp_head', 'wp_generator' );

if ( $is_added !== false ) {
	# Funktion wurde gefunden
}