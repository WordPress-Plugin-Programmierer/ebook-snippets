<?php
/*
Plugin Name: Konfigurator-Rollen-Plugin
*/

register_activation_hook( __FILE__, 'mm_add_role' );

function mm_add_role() {
	add_role(
		'configurator',
		'Konfigurator',
		array(
			'read'           => true,
			'manage_options' => true
		)
	);
}