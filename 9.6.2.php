<?php
/*
Plugin Name: ABC-Plugin
Plugin URI: http://my-website.com/abc-plugin/
Description: The plugin updates itself
Author: Max Mustermann
Author URI: http://my-website.com/
Version: 1.0.0
Text Domain: abc-plugin
Domain Path: /langs/
*/

add_filter( 'pre_set_site_transient_update_plugins', 'mm_update_plugins' );

function mm_update_plugins( $transient_value ) {
	global $mm_update_checked, $wp_version;

	// Wir senden die Anfrage nur beim zweiten Request
	if ( ! isset( $mm_update_checked ) ) {
		$mm_update_checked = false;

		return $transient_value;
	}

	$plugin_basename = plugin_basename( __FILE__ );

	// Es wird nur das eigene Plugin übertragen und auf Updates überprüft
	$plugins = array( $plugin_basename => get_plugin_data( __FILE__ ) );

	$options = array(
		'timeout'    => ( ( defined( 'DOING_CRON' ) && DOING_CRON ) ? 30 : 3 ),
		'body'       => array(
			'plugins' => json_encode( $plugins )
		),
		'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' )
	);

	$raw_response = wp_remote_post( 'http://my-website.com/update.php', $options );

	if ( is_wp_error( $raw_response ) || 200 != wp_remote_retrieve_response_code( $raw_response ) ) {
		return $transient_value;
	}

	$response = json_decode( wp_remote_retrieve_body( $raw_response ), true );

	// json_decode() git NULL zurück wenn die Daten nicht dekodiert werden konnten.
	if ( is_null( $response ) ) {
		return $transient_value;
	}

	// Überprüfe, ob der Schlüssel 'plugins' im Array existiert
	if ( ! isset( $response['plugins'] ) ) {
		return $transient_value;
	}

	// Füge die Daten der ursprünglichen Anfrage und die aktuelle Anfrage zusammen
	foreach ( $response['plugins'] as $plugin => $plugin_data ) {
		$transient_value->response[ $plugin ] = (object) $plugin_data;
	}

	unset( $mm_update_checked );

	return $transient_value;
}