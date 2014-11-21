<?php
/*
Plugin Name: Second-Level-Menüpunktes in Dashboard
*/

add_action( 'admin_menu', 'mm_admin_menu' );

function mm_admin_menu() {
	add_dashboard_page(
		'Mein Untermenü-Titel',
		'Untermenü',
		'manage_options',
		'mm-meins-unter-1',
		'mm_sub1_page_render'
	);
}

function mm_sub1_page_render() {
	echo '<h1>Mein Untermenü-Titel</h1>';
}