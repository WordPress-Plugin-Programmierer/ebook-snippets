<?php
/*
Plugin Name: do_action_ref_array() Beispiel 2
*/

add_action( 'check_passwords', 'mm_check_passwords', 10, 3 );

function mm_check_passwords( $user_name, $pass1, $pass2 ) {
	$pass1 = md5( $pass1 );
	$pass2 = md5( $pass2 );
}

