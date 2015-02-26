<?php
/*
Plugin Name: Daten in einer Datenbank ersetzen
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$replaced = $wpdb->replace(
// Der Tabellenname
	$wpdb->prefix . 'mm_example_table',

	// Ersetzung
	array(
		'mm_id'    => 10,
		'mm_name'  => 'Test6',
		'mm_value' => 'Value6',
	),

	// Formatierung
	array(
		'%d',
		'%s',
		'%s',
	)
);

var_dump( $replaced );