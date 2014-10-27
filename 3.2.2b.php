<?php
/*
Plugin Name: add_action() Beispiel
*/

add_action( 'save_post', 'mm_save_post', 20, 3 );

function mm_save_post( $post_ID, $post, $update ) {
	if ( ! $update ) {
		add_post_meta( $post_ID, 'mein-post-meta-wert', 5 );
	}
}