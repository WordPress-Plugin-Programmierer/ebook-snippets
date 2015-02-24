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
		echo '<label for="' . $this->get_field_id( 'field_1' ) . '">Feld 1</label>';
		echo '<input id="' . $this->get_field_id( 'field_1' ) . '" class="widefat" name="' . $this->get_field_name( 'field_1' ) . '" type="text" value="" />';
		echo '</p>';
	}
}


add_action( 'widgets_init', 'mm_register_mein_widget' );

function mm_register_mein_widget() {
	register_widget( 'MM_Mein_Widget' );
}