<?php
/*
Plugin Name: Entfernen der Transportmöglichkeit CURL
*/

add_filter( 'http_api_transports', 'mm_remove_curl_transport', 10 );
function mm_remove_curl_transport( $transports ) {

	if ( ( $key = array_search( 'curl', $transports ) ) !== false ) {
		unset( $transports[$key] );
	}

	return $transports;
}
