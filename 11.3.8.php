<?php
/*
Plugin Name: Artikeltyp-Features entfernen
*/

add_action( 'init', 'mm_register_post_type' );

function mm_register_post_type() {

	register_post_type( 'books' );
	add_post_type_support( 'books', array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ) );
	remove_post_type_support( 'books', array( 'title', 'editor' ) );

	// Es verbleiben: 'author', 'thumbnail', 'excerpt', 'comments'

}