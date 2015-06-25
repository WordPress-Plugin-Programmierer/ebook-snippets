<?php
/*
Plugin Name: Book Post Type mit Capability- und map_met_cap Option
*/

add_action( 'init', 'mm_register_post_type' );

function mm_register_post_type() {

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
		'capabilities'       => array(
			// Meta-Capabilities
			'edit_post'          => 'edit_book',
			'read_post'          => 'read_book',
			'delete_post'        => 'delete_book',
			// primitive Capabilities
			'edit_posts'         => 'edit_posts',
			'edit_others_posts'  => 'edit_others_books',
			'publish_posts'      => 'publish_books',
			'read_private_posts' => 'read_private_books',

		),
		'has_archive'        => true,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
	);

	register_post_type( 'book', $args );

}