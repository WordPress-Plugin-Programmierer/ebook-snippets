<?php
/*
Plugin Name: Mehrere Benutzer auslesen
*/

// Alle Abonnenten eines Blogs anzeigen
$users = get_users( 'blog_id=1&orderby=nicename&role=subscriber' );

// Benutzung der Suchfunktion und einer Wildcard (*)
$users = get_users( 'search=max mu*' );

// Nur Benutzer mit der ID 1, 10, 15 oder 3. Außerdem aufsteigend nach 'nicename' sortiert.
$users = get_users( array(
	'include' => array( 1, 10, 15, 3 ),
	'oderby'  => 'nicename',
	'order'   => 'ASC'
) );

// Findet alle Benutzer aus, die im Feld 'billing_company' den String 'Test-Unternehmen' eingegeben haben.
$users = get_users( array(
	'meta_query' => array(
		array(
			'key'     => 'billing_company',
			'value'   => 'Test-Unternehmen',
			'compare' => '='
		)
	),
	'oderby'     => 'nicename',
	'order'      => 'ASC'
) );

// Alle obigen Beispiele geben immer ein Array mit WP_User-Objekten zurück. Dieses Beispiel gibt stdClass-Objekte zurück:
$users = get_users( array(
	'fields' => array( 'display_name' )
) );

var_dump( $users );