<?php
/*
Plugin Name: Eine Zeile aus einer Datenbank lesen
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$row = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'mm_example_table ORDER BY mm_id ASC LIMIT 1' );

var_dump( $row );