<?php
/*
Plugin Name: Hinzufügen von neuen Rechten zu einer Rolle
*/

register_activation_hook( __FILE__, 'mm_add_capability' );

function mm_add_capability() {
	$new_role = add_role(
		'configurator',
		'Konfigurator',
		array(
			'read'           => true,
			'manage_options' => true
		)
	);

	if ( is_a( $new_role, 'WP_Role' ) ) {
		$new_role->add_cap( 'can_edit_mm_settings' );
	}

}