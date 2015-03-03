<?php
/*
Plugin Name: Neuen Benutzer anlegen
*/

$user_id = wp_create_user( 'gonzo', 'kjn76-y1!3a', 'gonzo@my-website.com' );

// ODER
$id = wp_insert_user( array(
	'user_pass'    => 'kjn76-y1!3a',
	'user_name'    => 'max',
	'user_email'   => 'max@mustermann.com',
	'user_url'     => 'http://my-website.com',
	'display_name' => 'Max Mustermann',
	'first_name'   => 'Max',
	'last_name'    => 'Mustermann',
	'rich_editing' => true
) );

if ( is_wp_error( $id ) ) {
	// Ein Fehler ist aufgetreten
}