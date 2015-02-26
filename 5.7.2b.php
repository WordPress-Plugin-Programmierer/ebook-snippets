<?php
/*
Plugin Name: Daten in einer Datenbank verändern (mehrere WHERE)
*/


/**
 * @var wpdb $wpdb
 */
global $wpdb;

$updated = $wpdb->update(
	$wpdb->prefix . 'mm_example_table',
	array(
		'mm_name'  => 'Test99',
		'mm_value' => 'Value99'
	),
	array(
		'mm_id'   => '1',
		'mm_name' => 'Test1'
	),
	array(
		'%s',
		'%s'
	),
	array(
		'%d',
		'%s'
	)
);

var_dump( $updated );