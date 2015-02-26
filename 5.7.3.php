<?php
/*
Plugin Name: Daten aus einer Datenbank löschen
*/


/**
 * @var wpdb $wpdb
 */
global $wpdb;

$deleted = $wpdb->delete(
// Der Tabellenname
	$wpdb->prefix . 'mm_example_table',

	// Die WHERE-Anweisungen
	array(
		'mm_id' => '1',
	),

	// Das Format der Daten in WHERE
	array(
		'%d',
	)
);

var_dump( $deleted );