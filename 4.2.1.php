<?php
/*
Plugin Name: Metabox erstellen
*/

add_action( 'add_meta_boxes', 'mm_add_meta_boxes' );

function mm_add_meta_boxes() {
	add_meta_box(
		'mm_test',
		'Metabox-Überschrift',
		'mm_meta_box',
		'post',
		'advanced',
		'default',
		array( 'arg1' => 'val1' )
	);
}

/**
 * @param WP_Post $post
 * @param array   $args
 */
function mm_meta_box( $post, $args ) {
	echo 'Meine Metabox Inhalte';
}

