<?php
/*
Plugin Name: Rolle auslesen
*/
add_action( 'admin_init', function () {
	$config_role = get_role( 'contributor' );

	if ( $config_role->has_cap( 'read' ) ) {
		// mach etwas
	} else {
		// mach etwas anderes
	}
} );