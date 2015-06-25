<?php
/*
Plugin Name: Taxonomie genre erstellen
*/

add_action( 'init', 'mm_register_taxonomy', 10 );

function mm_register_taxonomy() {

	$labels = array(
		'name'              => 'Genres',
		'singular_name'     => 'Genre',
		'search_items'      => 'Search Genres',
		'all_items'         => 'All Genres',
		'parent_item'       => 'Parent Genre',
		'parent_item_colon' => 'Parent Genre:',
		'edit_item'         => 'Edit Genre',
		'update_item'       => 'Update Genre',
		'add_new_item'      => 'Add New Genre',
		'new_item_name'     => 'New Genre Name',
		'menu_name'         => 'Genre',
	);

	register_taxonomy( 'genre', '', array(
		'labels' => $labels
	) );

}