<?php
/*
Plugin Name: Beispiel Plugin Deinstallation
*/

register_activation_hook( __FILE__, 'mm_activation' );

function mm_activation() {
	register_uninstall_hook( __FILE__, 'mm_uninstall' );
}

function mm_uninstall() {
	/* Ihr Code */
}