<?php
/*
Plugin Name: Entfernen von Rechten einer Rolle
*/

register_deactivation_hook( __FILE__, 'mm_remove_capability' );

function mm_remove_capability() {
	$role = get_role( 'configurator' );

	if ( is_a( $role, 'WP_Role' ) ) {
		$role->remove_cap( 'can_edit_mm_settings' );
	}

}