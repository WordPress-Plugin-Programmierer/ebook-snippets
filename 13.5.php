<?php
/*
Plugin Name: Anzahl der Terme in einer Taxonomie
*/

$terms = get_terms( array(
	'fields'   => 'count',
	'taxonomy' => 'category',
) );

var_dump( $terms );