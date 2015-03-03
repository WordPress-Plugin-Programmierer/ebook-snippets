<?php
/*
Plugin Name: Benutzerrollen übersetzen
*/

global $wp_roles;

$role_names = $wp_roles->get_names();

$user = get_user_by( 'id', 2 );

if ( $user ) {
	echo __( 'You have the following roles:', 'mm' );

	echo '<ul>';

	foreach ( $user->roles as $role ) {
		echo '<li>' . translate_user_role( $role_names[ $role ] ) . '</li>';
	}

	echo '</ul>';
}