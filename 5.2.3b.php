<?php
/*
Plugin Name: Rechte zu Benutzer hinzufügen
*/

register_activation_hook( __FILE__, 'mm_add_user_capability' );

function mm_add_user_capability() {
	$user = get_user_by( 'id', 1 );

	if ( is_a( $user, 'WP_User' ) ) {
		$user->add_cap( 'can_edit_mm_settings' );
	}

	die();
}