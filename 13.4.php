<?php
/*
Plugin Name: get_term_by() Beispiele
*/

// 1
var_dump( get_term_by( 'slug', 'roman', 'category' ) );

// 2
var_dump( get_term_by( 'name', 'Roman', 'category' ) );

// 3
var_dump( get_term_by( 'name', 'roman', 'category' ) );

// 4
var_dump( get_term_by( 'id', '17', 'category' ) );

// 5
var_dump( get_term_by( 'term_taxonomy_id', '18', 'category' ) );
