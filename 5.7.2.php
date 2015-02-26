<?php
/*
Plugin Name: Daten in einer Datenbank verändern
*/


/**
 * @var wpdb $wpdb
 */
global $wpdb;

$updated = $wpdb->update(

// Tabellenname
	$wpdb->prefix . 'mm_example_table',

	// Die neuen Daten
	array(
		'mm_name'  => 'Test99',
		'mm_value' => 'Value99'
	),

	// WHERE-Anweisung (welche Zeile(n) soll editiert werden)
	array(
		'mm_id' => '1'
	),

	// Formatierung der Daten
	array(
		'%s',
		'%s'
	),

	// Formatierung der WHERE-Anweisung
	array(
		'%d'
	)
);

var_dump( $updated );