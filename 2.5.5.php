<?php
/*
Plugin Name: SQL Anweisungen formatieren
*/

global $wpdb;

// Das einzelne Anführungszeichen am Ende sorgt für Probleme bei der SQL-Abfrage
$var = "dangerous'";

// Diese Funktion sollte einen Integer-Wert zurückgeben.
$id = some_foo_number();

$wpdb->query( $wpdb->prepare( "UPDATE $wpdb->posts SET post_title = %s WHERE ID = %d", $var, $id ) );
