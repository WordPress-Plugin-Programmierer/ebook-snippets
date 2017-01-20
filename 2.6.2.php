<?php
/*
Plugin Name: PHPDoc für Funktionen und Methoden
*/

/**
 * Lässt das Fahrzeug fahren.
 *
 * Legt den ersten Gang des Fahrzeugs ein und beschleunigt.
 *
 * @since 1.0.3
 *
 * @see   Fahrzeug::fahren()
 *
 * @param object $fahrzeug Eine Klasse des Typs Fahrzeug.
 * @param int    $gang Optional. Der Gang der eingelegt werden soll.
 *
 * @return float Geschwindigkeit
 */
function fahren( $fahrzeug, $gang = 1 ) {

	$fahrzeug->gang_einlegen( $gang );

	return $fahrzeug->geschwindigkeit();
}

?>