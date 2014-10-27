<?php
/*
Plugin Name: add_action() Beispiel
*/

add_action( 'save_post', 'mm_save_post' );

function mm_save_post( $post_ID ) {
	add_post_meta( $post_ID, 'mein-post-meta-wert', 5 );
}