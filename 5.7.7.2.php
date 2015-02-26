<?php
/*
Plugin Name: Letzten SQL-Fehler ausgeben
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$wpdb->print_error();