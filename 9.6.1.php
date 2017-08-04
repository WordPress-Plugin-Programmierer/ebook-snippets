<?php
/*
Plugin Name: Facebook Share Shortcode
Plugin URI: http://my-website.com/fb-share-shortcode/
Description: Allows to show the number of shares for a certain URL.
Author: Max Mustermann
Author URI: http://my-website.com/
Version: 1.0.0
Text Domain: fb-share-shortcode
Domain Path: /langs/
*/


add_shortcode( 'no-of-fb-shares', 'mm_no_of_fb_shares_shortcode' );

function mm_no_of_fb_shares_shortcode( $atts, $content, $name ) {

	$atts = shortcode_atts( array( 'url' => null ), $atts, $name );

	$share_count = mm_get_no_of_fb_shares( $atts['url'] );

	if ( empty( $share_count ) ) {
		return '';
	}

	return sprintf(
		'<span class="no-of-tweets">Dieser Artikel wurde %d mal auf Facebook geteilt.</span>',
		$share_count
	);
}


function mm_get_no_of_fb_shares( $share_url = null ) {

	if ( is_null( $share_url ) ) {
		$share_url = get_permalink( get_the_ID() );
	}

	if ( empty( $share_url ) ) {
		return 0;
	}

	// Die Anfrage URL wird zusammengesetzt
	$request_url = sprintf(
		'http://graph.facebook.com/?fields=og_object{id},share&id=%s',
		urlencode( $share_url )
	);

	// Die eigentlichen Anfrage wird gestartet
	$response = wp_remote_get( $request_url );

	// Ein etwaiger Fehler wird umgangen
	if ( is_wp_error( $response ) ) {
		return 0;
	}

	// Falls der Statuscode nicht 200 ist, wird 0 zurückgegeben
	if ( 200 != wp_remote_retrieve_response_code( $response ) ) {
		return 0;
	}

	// Wir lesen die Daten aus
	$data = wp_remote_retrieve_body( $response );

	// Und versuchen Sie zu dekodieren
	$data = json_decode( $data );

	// Das Dekodieren schlug Fehl
	if ( is_null( $data ) ) {
		return 0;
	}

	// Der gesuchte Wert existiert nicht
	if ( ! isset( $data->share->share_count ) ) {
		return 0;
	}

	return intval( $data->share->share_count );
}
