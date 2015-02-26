<?php
/*
Plugin Name: Cache leeren
*/

/**
 * @var wpdb $wpdb
 */
global $wpdb;

$wpdb->flush();