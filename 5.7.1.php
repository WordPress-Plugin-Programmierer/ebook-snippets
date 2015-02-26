<?php
/*
Plugin Name: Daten in Datenbank einfügen
*/


/**
 * @var wpdb $wpdb
 */
global $wpdb;

$inserted = $wpdb->insert(
	$wpdb->prefix . 'mm_example_table',
	array(
		'mm_name'  => 'Test3',
		'mm_value' => 'Value3'
	), array(
		'%s',
		'%s'
	)
);

var_dump( $inserted );
