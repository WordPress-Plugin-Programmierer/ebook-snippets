<?php
/*
Plugin Name: Generische Datenbankabfragen (mit OBJECT_K als Rückantwort)
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$results = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'mm_example_table LIMIT 3', OBJECT_K );

var_dump( $results );