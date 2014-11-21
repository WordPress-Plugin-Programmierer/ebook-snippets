<?php
/*
Plugin Name: Metabox mit Checkbox erstellen (AJAX-Save)
*/

add_action( 'add_meta_boxes', 'mm_add_meta_boxes' );

function mm_add_meta_boxes() {
	add_meta_box( 'mm_test', 'Meine Metabox Überschrift', 'mm_meta_box', 'post' );
}

function mm_meta_box( $post, $args ) {

	$mm_metabox_zusatz = (bool) get_post_meta( $post->ID, 'mm_metabox_zusatz', true );

	echo '<input id="mm_metabox_zusatz" type="checkbox" value="1" name="mm_metabox_zusatz" ' . checked( $mm_metabox_zusatz, true, false ) . ' />';
	echo '<label for="mm_metabox_zusatz">Zusatzfunktion aktivieren</label>';
}

add_action( 'save_post', 'mm_save_meta_box' );

function mm_save_meta_box( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	$mm_metabox_zusatz = filter_input( INPUT_POST, 'mm_metabox_zusatz', FILTER_VALIDATE_INT );

	if ( empty( $mm_metabox_zusatz ) ) {
		delete_post_meta( $post_id, 'mm_metabox_zusatz' );
	} else {
		update_post_meta( $post_id, 'mm_metabox_zusatz', $mm_metabox_zusatz );
	}

}