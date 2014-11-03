<?php
/*
Plugin Name: do_action_ref_array() Beispiel
*/
add_action( 'admin_bar_menu', 'mm_admin_bar_menu' );

/**
 * @param WP_Admin_Bar $wp_admin_bar
 */
function mm_admin_bar_menu( $wp_admin_bar ) {
	$wp_admin_bar->add_menu( array(
		'href'  => 'http://beispiel.com',
		'title' => 'Beispiel.com'
	) );
}