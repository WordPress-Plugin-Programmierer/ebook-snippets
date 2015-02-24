<?php
/*
Plugin Name: Einstellungsbereiche (Sections) registrieren
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
}

function mm_settings_section_cb_1() {
	echo 'Dies ist die erste Section.';
}