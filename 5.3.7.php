<?php
/*
Plugin Name: Rechte zur Rolle 'Konfigurator' hinzufügen
*/

register_deactivation_hook( __FILE__, 'mm_remove_capability' );

function mm_remove_capability() {
	$role = get_role( 'configurator' );

	if ( is_a( $role, 'WP_Role' ) && ! $role->has_cap( 'can_edit_mm_settings' ) ) {
		$role->remove_cap( 'can_edit_mm_settings' );
	}

}