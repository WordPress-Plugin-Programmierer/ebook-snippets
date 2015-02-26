<?php
/*
Plugin Name: Ein Feld mit Callback-Funktion registrieren
*/

add_action( 'admin_init', 'mm_register_settings' );

function mm_register_settings() {

	register_setting(
		// Gruppe
		'mm_settings_group',
		// Name
		'mm_settings_section_1_field_1',
		// Callback Funktion
		'sanitize_text_field'
	);

}
