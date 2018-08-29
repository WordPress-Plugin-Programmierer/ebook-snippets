<?php

include __DIR__ . '/types/books.php';
include __DIR__ . '/types/book-authors.php';

add_action( 'init', 'mm_register_post_types' );

function mm_register_post_types() {

	mm_register_book_post_type();
	mm_register_author_post_type();

	register_post_meta(
		'book',
		'book_author',
		[
			'single'       => true,
			'show_in_rest' => false,
			'description'  => __( 'The ID of the author of the book.', 'mm-rest-example' ),
			'type'         => 'integer',
		]
	);

}