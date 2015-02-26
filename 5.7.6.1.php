<?php
/*
Plugin Name: SQL Werte filtern
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$status = esc_sql( $_POST['status'] );

$wpdb->get_var( 'SELECT ID FROM ' . $wpdb->prefix . 'mm_example_table WHERE mm_name = "$name"' );
