<?php
/*
Plugin Name: SQL Anweisungen formatieren
*/

$name   = esc_sql( $name );
$status = esc_sql( $status );

$wpdb->get_var( "SELECT etwas FROM tablenname WHERE foo = '$name' and status = '$status'" );
