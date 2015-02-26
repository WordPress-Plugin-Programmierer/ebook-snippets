<?php
/*
Plugin Name: Eine Variable aus einer Datenbank lesen (mehrere Rückgabewerte)
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$result = $wpdb->get_var( 'SELECT * FROM ' . $wpdb->prefix . 'mm_example_table ORDER BY mm_id ASC', 1, 4 );

var_dump( $result );