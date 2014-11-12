<?php
/*
Plugin Name: option_(option name) Filter
*/

register_activation_hook( __FILE__, 'mm_activate' );
function mm_activate() {
	add_option( 'mm_options', array(
		'einstellung1' => true,
		'einstellung2' => false
	) );
}

add_filter( 'option_mm_options', 'mm_filter_option' );
function mm_filter_option( $value ) {
	$value['einstellung3'] = 5;

	return $value;
}

?>