<?php
/*
Plugin Name: Standardwerte von Shortcode Attributen
*/

add_shortcode( 'mm_current_date_time', 'mm_current_date_time_shortcode' );

function mm_current_date_time_shortcode( $atts, $content, $name ) {
	$atts = shortcode_atts( array(
		'date_format' => 'd.m.Y',
		'time_format' => 'G:i'
	), $atts, $name );

	return current_time( $atts['date_format'] . ' ' . $atts['time_format'] );
}