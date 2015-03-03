<?php
/*
Plugin Name: Aktuellen Benutzer auslesen
*/

global $current_user;

var_dump( $current_user ); // gibt eventuell NULL zurück, falls der Benutzer noch nicht in die globale Variable geladen wurde.

$r = get_currentuserinfo();

var_dump( $current_user ); // Gibt ein WP_User-Objekt zurück, falls der Benutzer geladen werden konnte. Ansonsten existiert die globale Variable nicht oder enthält den Wert NULL.

// $r enthält nur dann den boolschen Wert FALSE wenn der Benutzer nicht geladen werden konnte oder wenn es sich bei der aktuellen Anfrage um einen XML-RPC Request handelte.
