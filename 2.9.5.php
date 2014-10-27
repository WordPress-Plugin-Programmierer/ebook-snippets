<?php
/*
Plugin Name: Beispiel Plugin Deaktivierung
*/

define( 'MM_PLUGIN_FILE', __FILE__ );

register_deactivation_hook( MM_PLUGIN_FILE, 'mm_deactivation' );

function mm_deactivation() {
	// mach etwas
}