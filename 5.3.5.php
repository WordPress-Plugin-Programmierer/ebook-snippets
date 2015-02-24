<?php
/*
Plugin Name: Rolle zu Benutzer hinzufügen
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

		$user = get_user_by( 'id', 2 );

		if ( is_a( $user, 'WP_User' ) ) {
			$user->add_role( 'configurator' );
		}
	}

}