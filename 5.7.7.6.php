<?php
/*
Plugin Name: WordPress Tabellen auslesen
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

var_dump( $wpdb->tables( 'all' ) );