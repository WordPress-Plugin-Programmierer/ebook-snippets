<?php
/*
Plugin Name: Sperren von Domains
*/

add_filter( 'pre_http_request', 'mm_pre_http_request', 10, 3 );

function mm_pre_http_request( $preempt = false, $args, $url ) {
	if ( false !== stripos( $url, 'wikipedia.org' ) ) {
		return new WP_Error( 999, 'You are not allowed to access wikipedia.org!' );
	}

	return $preempt;
}

var_dump( wp_remote_get( 'http://de.wikipedia.org' ) );