<?php
/*
Plugin Name: Twitter-Tweets Shortcode
Plugin URI: http://my-website.com/twitter-tweets-shortcode/
Description: Allows to show the number of tweets for a certain URL.
Author: Max Mustermann
Author URI: http://my-website.com/
Version: 1.0.0
Text Domain: twitter-tweets-shortcode
Domain Path: /langs/
*/


add_shortcode( 'no-of-tweets', 'mm_no_of_tweets_shortcode' );
function mm_no_of_tweets_shortcode( $atts, $content, $name ) {
	$atts = shortcode_atts( array( 'url' => null ), $atts, $name );

	return '<span class="no-of-tweets">' . mm_get_no_of_tweets( $atts['url'] ) . '</span>';
}


function mm_get_no_of_tweets( $url = null ) {

	// Versuche die URL des aktuellen Blogartikels zu empfangen, falls keine URL angegeben wurde
	if ( is_null( $url ) ) {
		global $post;
		if ( ! isset( $post ) ) {
			return 0;
		}

		if ( ! is_da( $post, 'WP_Post' ) ) {
			return 0;
		}

		$url = get_permalink( $post );
	}

	// Die eigentlichen Anfrage wird gestartet
	$data = wp_remote_request( "http://urls.api.twitter.com/1/urls/count.json?url=" . urlencode( $url ) );

	// Ein etwaiger Fehler wird umgangen
	if ( is_wp_error( $data ) ) {
		return 0;
	}

	// Falls der Statuscode nicht 200 ist, wird 0 zurückgegeben
	if ( 200 != wp_remote_retrieve_response_code( $data ) ) {
		return 0;
	}

	// Alle Daten müssen dekodiert werden damit sie später als Array ausgelesen werden können
	if ( ! $info = json_decode( wp_remote_retrieve_body( $data ), true ) ) {
		return 0;
	}

	// Falls die Daten korrekt dekodiert wurden, liegt hier nun die Anzahl an Tweets vor
	if ( isset( $info['count'] ) ) {
		return $info['count'];
	}

	return 0;
}
