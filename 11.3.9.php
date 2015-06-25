<?php
/*
Plugin Name: Artikeltyp-Features zurückgeben
*/

add_action( 'init', 'mm_register_post_type' );

function mm_register_post_type() {

	register_post_type( 'books' );
	add_post_type_support( 'books', array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ) );
	remove_post_type_support( 'books', array( 'title', 'editor' ) );

	var_dump( get_all_post_type_supports( 'books' ) );

}