<?php
/*
Plugin Name: Übersetzen von JavaScript-Inhalten
*/

add_action( 'wp_enqueue_scripts', 'mm_enqueue_scripts' );

function mm_enqueue_scripts() {
// Registrierung des Scripts
	wp_register_script( 'mm-script', plugin_dir_url( __FILE__ ) . 'js/mm-script.js' );

// Einbinden des Scripts
	wp_enqueue_script( 'mm-script' );

// Lokalisierung
	wp_localize_script( 'mm-script', 'MM_Translation', array(
		'alert'   => __( 'Warning', 'mm_trans' ),
		'message' => __( 'Are you sure?', 'mm_trans' ),
		'success' => __( 'It works!', 'mm_trans' )
	) );
}