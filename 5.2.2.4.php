<?php
/*
Plugin Name: map_meta_cap Beispiel
*/

add_action( 'save_post', function () {

	var_dump( map_meta_cap( 'edit_post', get_current_user_id() ) );
	die();

} );