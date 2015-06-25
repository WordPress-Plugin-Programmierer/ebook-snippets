<?php
/*
Plugin Name: Taxonomie und Artikeltyp zusammenführen
*/

add_action( 'wp_loaded', 'mm_merge_book_genre' );

function mm_merge_book_genre() {
	register_taxonomy_for_object_type( 'genre', 'book' );
}