<?php
/*
Plugin Name: user_contactmethods Filter
*/

add_filter( 'user_contactmethods', 'mm_add_contactmethods', 10, 2 );

function mm_add_contactmethods( $methods, $user = null ) {
	$methods['googleplus'] = __( 'Google+' );
	$methods['twitter']    = __( 'Twitter' );

	return $methods;
}