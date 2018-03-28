<?php

namespace f\tel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


register_activation_hook( TEL_PLUGIN_FILE, '\f\tel\plugin_activation' );

/**
 * Plugin activation.
 * Create a new database table for outgoing links if it does not already exist.
 *
 * @since 0.1.0
 */
function plugin_activation() {

	if ( ! function_exists( 'dbDelta' ) ) {
		require ABSPATH . 'wp-admin/includes/upgrade.php';
	}

	global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	dbDelta( "CREATE TABLE `{$wpdb->prefix}outgoing_links` (
		`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`title` varchar(100) DEFAULT NULL,
		`slug` varchar(100) DEFAULT NULL,
		`link` text,
		PRIMARY KEY (`id`),
		UNIQUE KEY `id` (`id`)
	) {$charset_collate};" );
}

require __DIR__ . '/backend.php';
new Backend();
