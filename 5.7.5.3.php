<?php
/*
Plugin Name: Eine Spalte aus einer Datenbank lesen
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$col = $wpdb->get_col( 'SELECT * FROM ' . $wpdb->prefix . 'mm_example_table ORDER BY mm_id ASC' );

var_dump( $col );