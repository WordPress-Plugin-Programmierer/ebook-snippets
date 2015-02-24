<?php
/*
Plugin Name: Formular in Widget einbinden
*/

class MM_Mein_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'mm_mein_widget',
			'Mein Widget',
			array( 'classname' => 'mm_mein_widget_class', 'description' => 'Macht etwas tolles' ),
			array( 'width' => 500 )
		);
	}

	public function form( $settings ) {
		echo '<p>';
		echo '<label>Feld 1</label>';
		echo '<input class="widefat" name="field_1" type="text" value="" />';
		echo '</p>';
	}
}


add_action( 'widgets_init', 'mm_register_mein_widget' );

function mm_register_mein_widget() {
	register_widget( 'MM_Mein_Widget' );
}