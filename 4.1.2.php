<?php
/*
Plugin Name: Second-Level Menü erstellen
*/

add_action( 'admin_menu', 'mm_admin_menu' );

function mm_admin_menu() {
	add_menu_page(
		'Mein Titel',
		'Mein Menü',
		'manage_options',
		'mm-meins',
		'mm_main_page_render',
		plugins_url( 'pacman.png', __FILE__ )
	);

	add_submenu_page(
		'mm-meins',
		'Mein Untermenü-Titel',
		'Untermenü',
		'manage_options',
		'mm-meins-unter-1',
		'mm_sub1_page_render'
	);
}

function mm_main_page_render() {
	echo '<h1>Mein Titel</h1>';
}

function mm_sub1_page_render() {
	echo '<h1>Mein Untermenü-Titel</h1>';
}

?>