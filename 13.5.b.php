<?php
/*
Plugin Name: get_terms() ohne Parameter
*/

$terms = get_terms( 'category' );

var_dump( $terms );