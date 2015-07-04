<?php
/*
Plugin Name: Terme im Frontend
*/

add_action( 'init', 'mm_register_taxonomy_and_post' );

function mm_register_taxonomy_and_post() {

	$tax_labels = array(
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

	register_taxonomy( 'genre', 'book', array(
		'labels' => $tax_labels
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
		// Hinzufügen des Taxonomies
		'taxonomies'         => array( 'genre' ),
	);

	register_post_type( 'book', $args );

}

add_shortcode( 'latest_book_posts', 'latest_book_posts_shortcode' );

function latest_book_posts_shortcode( $atts, $content, $name ) {
	// shortcode_atts() wird hier nicht benötigt
	//$atts = shortcode_atts( array(), $atts, $name );

	$book_loop = new WP_Query( array(
		'post_type'      => 'book',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'posts_per_page' => 10
	) );

	if ( ! $book_loop->have_posts() ) {
		return 'Keine Bücher vorhanden';
	}

	$output = '<ul class="book-loop">';

	while ( $book_loop->have_posts() ) {
		$book_loop->the_post();

		$title = the_title( '<a href="' . get_the_permalink() . '">', '</a>', false );

		$terms = '';
		if ( has_term( '', 'genre' ) ) {
			$terms = sprintf( ( '(Genres: %s)' ), get_the_term_list( get_the_ID(), 'genre', '', ' - ' ) );
		}

		$output .= sprintf( '<li>%s %s</li>', $title, $terms );
	}

	$output .= '</ul>';

	wp_reset_query();

	return $output;
}