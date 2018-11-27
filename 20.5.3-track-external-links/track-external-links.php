<?php
/*
  Plugin Name: Track External Links
  Plugin URI: https://wp-plugin-erstellen.de
  Version: 0.4.0
  Author: Florian Simeth
  Author URI: https://florian-simeth.de
  Description: A plugin that allows to track external links.
  Text Domain: track-external-links
  Domain Path: /languages
  License: GPL
 */

define( 'TEL_PLUGIN_FILE', __FILE__ );

if ( version_compare( PHP_VERSION, '5.3.0', '<' ) ) {
	add_action( 'admin_notices', 'tel_old_php_notice' );

	function tel_old_php_notic() {

		printf(
			'<div class="notice error"><p>%s</p></div>',
			sprintf(
				__( 'Hey mate! Sorry for interrupting you. It seem\'s that you\'re using an old PHP version (your current version is %s). You should upgrade to at least 5.3.0 or higher in order to use the "Track External" Links plugin. Thank you!', 'track-external-links' ),
				esc_html( PHP_VERSION )
			)
		);
	}

	# sorry. The plugin will not work with an old PHP version.
	return;
}

require __DIR__ . '/inc/bootstrap.php';
