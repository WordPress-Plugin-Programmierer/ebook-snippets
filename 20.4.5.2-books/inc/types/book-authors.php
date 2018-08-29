<?php

function mm_register_author_post_type() {
	$labels = array(
		'name'               => 'Book Authors',
		'singular_name'      => 'Book Author',
		'menu_name'          => 'Book Authors',
		'name_admin_bar'     => 'Book Author',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Book Author',
		'new_item'           => 'New Book Author',
		'edit_item'          => 'Edit Book Author',
		'view_item'          => 'View Book Author',
		'all_items'          => 'All Book Authors',
		'search_items'       => 'Search Book Authors',
		'parent_item_colon'  => 'Parent Book Authors:',
		'not_found'          => 'No book authors found.',
		'not_found_in_trash' => 'No book authors found in Trash.'
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => 'book-author',
		'rewrite'            => array( 'slug' => 'book-author' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'show_in_rest'       => true,
		'rest_base'          => 'book-authors',
	);

	register_post_type( 'book-author', $args );
}