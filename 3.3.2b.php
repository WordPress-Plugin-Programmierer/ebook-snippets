<?php
/*
Plugin Name: add_filter mit mehreren Parametern
*/

add_filter( 'user_contactmethods', 'mm_add_contactmethods', 10, 2 );

function mm_add_contactmethods( $methods, $user = null ) {
	$methods['googleplus'] = __( 'Google+' );

	return $methods;
}