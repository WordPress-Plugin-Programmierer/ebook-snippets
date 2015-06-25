<?php
/*
Plugin Name: Taxonomie von Objekt entfernen
*/

add_action( 'init', 'mm_register_post_type_taxonomy' );

function mm_register_post_type_taxonomy() {

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

	// Registrierung des Taxonomies
	// und zusammenführen mit Artikeltyp 'book'
	register_taxonomy( 'genre', 'book', array(
		'labels' => $labels
	) );

	$labels = array(
		'name'               => 'Books',
		'singular_name'      => 'Book',
		'menu_name'          => 'Books',
		'name_admin_bar'     => 'Book',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Book',
		'new_item'           => 'New Book',
		'edit_item'          => 'Edit Book',
		'view_item'          => 'View Book',
		'all_items'          => 'All Books',
		'search_items'       => 'Search Books',
		'parent_item_colon'  => 'Parent Books:',
		'not_found'          => 'No books found.',
		'not_found_in_trash' => 'No books found in Trash.'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => 'book',
		'rewrite'            => array( 'slug' => 'book' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		// Zusammenführen des Artikeltyps mit der Taxonomie 'genre'
		'taxonomies'         => array( 'genre' )
	);

	// Registrieren des Artikeltyps 'book'
	register_post_type( 'book', $args );
}

add_action( 'wp_loaded', 'mm_merge_book_genre' );

function mm_merge_book_genre() {

	// Trennen der Verbindung zwischen Artikeltyp 'book'
	// und Taxonomie 'genre'
	unregister_taxonomy_for_object_type( 'genre', 'book' );
}