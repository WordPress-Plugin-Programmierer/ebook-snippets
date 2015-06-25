<?php
/*
Plugin Name: Existenz eines Shortcodes prüfen
*/

add_shortcode( 'mm_current_date_time', 'mm_current_date_time_shortcode' );

function mm_current_date_time_shortcode( $atts, $content, $name ) {
	$atts = shortcode_atts( array(
		'date_format' => 'd.m.Y',
		'time_format' => 'G:i'
	), $atts, $name );

	return current_time( $atts['date_format'] . ' ' . $atts['time_format'] );
}

var_dump( shortcode_exists( 'mm_current_date_time' ) );

remove_shortcode( 'mm_current_date_time' );

var_dump( shortcode_exists( 'mm_current_date_time' ) );
