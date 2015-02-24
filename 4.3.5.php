<?php
/*
Plugin Name: Eine Einstellung (Setting) zur Section hinzufügen
*/

add_action( 'admin_init', 'mm_register_settings' );

function mm_register_settings() {
	global $mm_page_hook;
	add_settings_section(
		'mm_settings_section_1',
		'Erste Settings Section',
		'mm_settings_section_cb_1',
		$mm_page_hook
	);

	add_settings_field(
		'mm_settings_section_1_field_1',
		'Feld 1',
		'mm_settings_section_cb_1_field_1',
		$mm_page_hook,
		'mm_settings_section_1',
		array(
			'page_hook' => $mm_page_hook,
			'label_for' => 'mm_settings_section_1_field_1'
		)
	);
}

function mm_settings_section_cb_1() {
	echo 'Dies ist die erste Section.';
}

function mm_settings_section_cb_1_field_1( $args ) {
	echo '<input id="' . $args['label_for'] . '" class="regular-text" type="text" value="' . esc_attr( $args['page_hook'] ) . '" name="mm_settings_section_1_field_1" />';
}
?>