<?php
/*
Plugin Name: Beispiel Plugin Aktivierung
*/

define( 'MM_PLUGIN_FILE', __FILE__ );

register_activation_hook( MM_PLUGIN_FILE, 'mm_activation' );

function mm_activation() {
	// mach etwas
}