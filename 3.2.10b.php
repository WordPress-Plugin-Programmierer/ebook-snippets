<?php
/*
Plugin Name: Menüeintrag
*/


add_action( 'admin_menu', 'wpautop_control_menu' );

function wpautop_control_menu() {
	add_submenu_page( 'options-general.php', 'Seitentitel', 'Menütitel', 'manage_options', 'menu-slug', 'mm_render_seitentitel' );
}