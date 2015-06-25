<?php
@header( 'Content-Type: application/json; charset=UTF-8' );

if ( ! isset( $_POST['plugins'] ) ) {
	echo json_encode( array(
		'success' => false,
		'message' => 'No plugins to test.',
		'plugins' => array()
	) );
	die();
}

$plugins = json_decode( stripslashes( $_POST['plugins'] ), true );

if ( is_null( $plugins ) ) {
	echo json_encode( array(
		'success' => false,
		'message' => 'Could not decode plugins.',
		'plugins' => array()
	) );
	die();
}

if ( ! is_array( $plugins ) ) {
	echo json_encode( array(
		'success' => false,
		'message' => 'Wrong format.',
		'plugins' => array()
	) );
	die();
}

// Diese Daten könnten auch in einer Datenbank stehen
$current_plugins = array(
	'abc-plugin/abc-plugin.php' => array(
		'id'          => '',
		'slug'        => 'abc-plugin',
		'plugin'      => 'abc-plugin/abc-plugin.php',
		'new_version' => '1.2.0',
		'url'         => 'http://my-website.com/abc-plugin/',
		'package'     => 'http://localhost/abc-plugin-1-2-0.zip'
	),
	'xyz-plugin/xyz-plugin.php' => array(
		'id'          => '',
		'slug'        => 'xyz-plugin',
		'plugin'      => 'xyz-plugin/xyz-plugin.php',
		'new_version' => '3.0.0',
		'url'         => 'http://my-website.com/xyz-plugin/',
		'package'     => 'http://localhost/xyz-plugin-3-0-0.zip'
	)
);

$update = array();

foreach ( $plugins as $plugin => $plugin_data ) {
	// Überspringe Plugins die nicht in $current_plugins enthalten sind
	if ( ! isset( $current_plugins[ $plugin ] ) ) {
		continue;
	}

	$new_plugin_version = $current_plugins[ $plugin ]['new_version'];
	$old_plugin_version = $plugin_data['Version'];

	if ( version_compare( $new_plugin_version, $old_plugin_version, '>' ) ) {
		$update[ $plugin ] = $current_plugins[ $plugin ];
	}

}

echo json_encode( array(
	'success' => true,
	'message' => '',
	'plugins' => $update
) );
