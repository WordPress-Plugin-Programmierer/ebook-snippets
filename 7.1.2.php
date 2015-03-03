<?php
/*
Plugin Name: Userdaten updaten
*/

$id = wp_update_user( array(
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