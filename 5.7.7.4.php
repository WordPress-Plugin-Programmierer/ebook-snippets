<?php
/*
Plugin Name: Spalteninformation einer Datenbank auslesen
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$wpdb->get_var( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'mm_example_table WHERE mm_name = %s AND mm_id = %d', $status, $id ) );

// Abruf des Typs der Spalte 0 (= mm_id)
var_dump( $wpdb->get_col_info( 'type', 0 ) );