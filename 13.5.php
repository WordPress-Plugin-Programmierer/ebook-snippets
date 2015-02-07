<?php
/*
Plugin Name: Anzahl der Terme in einer Taxonomie
*/

$terms = get_terms( 'category', array(
'fields' => 'count'
) );

var_dump( $terms );