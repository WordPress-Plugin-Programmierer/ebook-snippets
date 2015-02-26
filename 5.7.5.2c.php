<?php
/*
Plugin Name: Eine Zeile aus einer Datenbank lesen (Angabe eines Offsets)
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$row = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'mm_example_table ORDER BY mm_id ASC', OBJECT, 2 );

var_dump( $row );