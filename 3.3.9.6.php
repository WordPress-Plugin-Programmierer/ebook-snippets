<?php
/*
Plugin Name: wp_mail_from Filter
*/

add_filter( 'wp_mail_from', 'mm_wp_mail_from' );

function mm_wp_mail_from( $original_email_address ) {
	return 'webmaster@beispieldomain.de';
}