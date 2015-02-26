<?php
/*
Plugin Name: Fehlerausgabe an- und ausschalten
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

// Anschalten
$wpdb->show_errors();

// Ausschalten
$wpdb->hide_errors();