<?php
/*
Plugin Name: Eine Variable aus einer Datenbank lesen
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$result = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'mm_example_table' );

var_dump( $result );