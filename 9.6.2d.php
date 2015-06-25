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
		'id'             => '',
		'slug'           => 'abc-plugin',
		'plugin'         => 'abc-plugin/abc-plugin.php',
		'new_version'    => '1.2.0',
		'url'            => 'http://my-website.com/abc-plugin/',
		'package'        => 'http://localhost/abc-plugin-1-2-0.zip',
		'upgrade_notice' => 'PLEASE BACKUP YOUR DATABASE BEFORE UPGRADING.',
		'name'           => 'ABC Plugin',
		'version'        => '1.2.0',
		'author'         => 'Max Mustermann',
		'requires'       => '3.6',
		'homepage'       => 'http://my-website.com/abc-plugin/',
		'downloaded'     => 999,
		'download_link'  => 'http://localhost/abc-plugin-1-2-0.zip',
		'external'       => true,
		'mm'             => true,
		'sections'       => array(
			'description'  => 'A plugin that updates itself.',
			'installation' => 'Please follow the instructions found in the documentation. Thanks!',
			'faq'          => '<h3>Question 1</h3><p>Answer 1</p><h3>Question 2</h3><p>Answer 2</p>',
			'screenshots'  => '',
			'changelog'    => '<ul><li>1.2.0<ul><li>Allows to show more plugin information.</li></ul></li><li>1.1.0<ul><li>Allows to update itself</li></ul></li><li>1.0.0<ul><li>Initial commit</li></ul></li></ul>',
			'other_notes'  => ''
		),
		'tested'         => '3.9.1'
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