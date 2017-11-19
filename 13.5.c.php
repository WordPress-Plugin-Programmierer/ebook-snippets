<?php
/*
Plugin Name: Keine leeren Kategorien zurückgeben
*/

$terms = get_terms( array(
	'taxonomy'   => 'category',
	'hide_empty' => false,
) );

var_dump( $terms );