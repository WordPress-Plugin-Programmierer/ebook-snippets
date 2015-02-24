<?php
/*
Plugin Name:  Entfernen von Rechten eines Benutzers
*/

register_deactivation_hook( __FILE__, 'mm_remove_user_capability' );

function mm_remove_user_capability() {
	$user = get_user_by( 'id', 1 );

	if ( is_a( $user, 'WP_User' ) ) {
		$user->remove_cap( 'can_edit_mm_settings' );
	}

}