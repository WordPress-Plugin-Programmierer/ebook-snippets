<?php
/*
Plugin Name: add_filter mit einem Parameter
*/

add_filter( 'show_admin_bar', 'mm_show_admin_bar' );

function mm_show_admin_bar( $show_admin_bar ) {
	return false;
}