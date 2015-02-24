<?php
/*
Plugin Name: Widget erstellen und registrieren
*/

class MM_Mein_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'mm_mein_widget',
			'Mein Widget'
		);
	}
}

add_action( 'widgets_init', 'mm_register_mein_widget' );

function mm_register_mein_widget() {
	register_widget( 'MM_Mein_Widget' );
}