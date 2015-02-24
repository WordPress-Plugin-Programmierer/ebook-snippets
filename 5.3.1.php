<?php
/*
Plugin Name: Auf eine Rolle überprüfen
*/

/**
 * @param string           $role
 * @param null|int|WP_User $user
 *
 * @return bool
 */
function mm_has_role( $role, $user = null ) {

	if ( is_numeric( $user ) ) {
		$user = get_userdata( $user );
	} elseif ( is_null( $user ) ) {
		$user = wp_get_current_user();
	}

	if ( ! is_a( $user, 'WP_User' ) ) {
		return false;
	}

	return in_array( $role, (array) $user->roles );
}