<?php
/*
Plugin Name: Rating in REST
Description: Custom Route with path variable.
*/

add_action( 'rest_api_init', 'mm_rest_init' );

function mm_rest_init() {

	register_rest_route( 'rating_plugin/v1', '/comment/(?P<id>[\d]+)/ratings', array(
		'methods'  => 'GET',
		'callback' => 'get_rating',
		'args'     => array(
			'id' => array(
				'description' => __( 'Unique identifier for the object.', 'rest-rating' ),
				'type'        => 'integer',
			),
		),
	) );
}

/**
 * @param \WP_REST_Request $request
 *
 * @return \WP_Error|\WP_REST_Response
 */
function get_rating( $request ) {

	$id = $request->get_param( 'id' );

	return rest_ensure_response( [] );
}
