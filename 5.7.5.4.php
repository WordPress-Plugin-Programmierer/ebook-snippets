<?php
/*
Plugin Name: Generische Datenbankabfragen
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'mm_example_table LIMIT 3' );

var_dump( $results );