<?php
/*
Plugin Name: JavaScripte einbinden
*/

add_action( 'wp_enqueue_scripts', 'mm_enqueue_scripts' );

function mm_enqueue_scripts() {
	wp_enqueue_script( 'mm-mein-js', plugins_url( 'assets/test.js', __FILE__ ) );
}