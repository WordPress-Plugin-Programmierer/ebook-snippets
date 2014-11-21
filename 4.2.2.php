<?php
/*
Plugin Name: Metabox mit Checkbox erstellen
*/

add_action( 'add_meta_boxes', 'mm_add_meta_boxes' );

function mm_add_meta_boxes() {
	add_meta_box( 'mm_test', 'Meine Metabox Überschrift', 'mm_meta_box', 'post' );
}

function mm_meta_box( $post, $args ) {
	echo '<input id="mm_metabox_zusatz" type="checkbox" value="1" name="mm_metabox_zusatz" />';
	echo '<label for="mm_metabox_zusatz">Zusatzfunktion aktivieren</label>';
}