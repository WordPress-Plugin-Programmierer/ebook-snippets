<?php
/*
Plugin Name: Hierarchische/nicht-hierarchische Terme
*/

// "Alle Kinder nach Term-ID 20"
$terms = get_term_children( 20, 'category' );

var_dump( $terms );

// Im Gegensatz dazu: get_terms()
$terms = get_terms( 'category', array(
	'hide_empty' => false,
	'child_of'   => 20,
	'fields'     => 'ids'
) );

var_dump( $terms );

