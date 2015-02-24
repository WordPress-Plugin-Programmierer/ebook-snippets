<?php
/*
Plugin Name: Konfigurator-Rollen-Plugin
*/

register_activation_hook( __FILE__, 'mm_add_role' );

function mm_add_role() {
	add_role(
		'configurator',
		'Konfigurator',
		array(
			'read'           => true,
			'manage_options' => true
		)
	);
}

register_deactivation_hook( __FILE__, 'mm_remove_role' );

function mm_remove_role() {

	$role_users = get_users( array(
			'role'   => 'configurator',
			'number' => 1
		)
	);

	if ( ! empty( $role_users ) ) {
		// Es existieren noch Benutzer mit der Rolle.
		// Diese sollten hier eine andere Benutzerrolle zugewiesen bekommen.
	}

	remove_role( 'configurator' );

}