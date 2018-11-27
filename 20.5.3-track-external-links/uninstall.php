<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

if ( ! WP_UNINSTALL_PLUGIN ) {
	exit();
}

/**
 * Delete the database table.
 */
call_user_func( function () {

	global $wpdb;

	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}outgoing_links" );

} );
