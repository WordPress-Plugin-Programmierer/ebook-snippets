<?php
/*
Plugin Name: Rating in REST
Description: Custom Route.
*/

add_action( 'rest_api_init', 'mm_rest_init' );

function mm_rest_init() {

	register_rest_route( 'rating_plugin/v1', '/comments/ratings', array(
		'methods'  => 'GET',
		'callback' => 'get_ratings',
	) );
}

/**
 * @param \WP_REST_Request $request
 *
 * @return \WP_Error|\WP_REST_Response
 */
function get_ratings( $request ) {

	return rest_ensure_response( [] );
}
