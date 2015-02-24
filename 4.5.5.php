<?php
/*
Plugin Name: Formulardaten von Widgets speichern
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

		$field_1 = isset( $settings['field_1'] ) ? $settings['field_1'] : 'Noch nichts gespeichert';

		echo '<p>';
		echo '<label for="' . $this->get_field_id( 'field_1' ) . '">Feld 1</label>';
		echo '<input id="' . $this->get_field_id( 'field_1' ) . '" class="widefat" name="' . $this->get_field_name( 'field_1' ) . '" type="text" value="' . esc_attr( $field_1 ) . '" />';
		echo '</p>';

	}

	public function update( $new_settings, $old_settings ) {

		// Nur Zahlen sind erlaubt
		$new_settings['field_1'] = intval( $new_settings['field_1'] );

		$new_settings['field_1'] = apply_filters( 'mm_mein_widget_field_1', $new_settings['field_1'] );

		return $new_settings;
	}

}


add_action( 'widgets_init', 'mm_register_mein_widget' );

function mm_register_mein_widget() {
	register_widget( 'MM_Mein_Widget' );
}