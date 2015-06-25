<?php
/*
Plugin Name: Eigenen Shortcode erstellen
*/

add_shortcode( 'mm_current_time', 'mm_current_time_shortcode' );

function mm_current_time_shortcode() {
	return current_time( 'd.m.Y' );
}