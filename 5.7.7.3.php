<?php
/*
Plugin Name: Letzten SQL-Fehler auslesen
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$last_error = $wpdb->last_error;