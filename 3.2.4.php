<?php
/*
Plugin Name: remove_action() Beispiel
*/

add_action( 'check_passwords', 'mm_check_passwords', 10, 3 );

function mm_check_passwords( $user_name, $pass1, $pass2 ) {
	/* ... */
}

// Fall 1
$was_removed = remove_action( 'check_passwords', 'mm_check_passwords', 10 );

// Fall 2
$was_removed_second = remove_action( 'check_passwords', 'mm_check_passwords', 5 );
