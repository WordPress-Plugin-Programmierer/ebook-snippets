<?php
/*
Plugin Name: Keine leeren Kategorien zurückgeben
*/

$terms = get_terms( 'category', array(
	'hide_empty' => false
) );

var_dump( $terms );