<?php
/*
Plugin Name: Eigenen Shortcode erstellen (mehrere Parameter)
*/

add_shortcode( 'mm_current_time', 'mm_current_time_shortcode' );

function mm_current_time_shortcode( $atts, $content, $name ) {
	var_dump( $atts ); 		// (1)
	var_dump( $content ); 	// (2)
	var_dump( $name ); 		// (3)

	if ( ! isset( $atts['date_format'] ) ) {
		$atts['date_format'] = 'd.m.Y';
	}

	return current_time( $atts['date_format'] );
}