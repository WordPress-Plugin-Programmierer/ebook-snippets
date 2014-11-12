<?php
/*
Plugin Name: Did Action
*/

// gibt int(0) zurück
var_dump( did_action( 'wp_head' ) );

// gibt int(1) zurück
add_action( 'wp_footer', function () {
	var_dump( did_action( 'wp_head' ) );
} );