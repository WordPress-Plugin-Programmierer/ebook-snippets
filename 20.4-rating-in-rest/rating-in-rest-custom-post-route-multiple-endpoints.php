<?php
/*
Plugin Name: Rating in REST
Description: Custom Route with multiple endpoints.
*/

add_action( 'rest_api_init', 'mm_rest_init' );

function mm_rest_init() {

	register_rest_route( 'rating_plugin/v1', '/ratings', array(
		array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => 'mm_fetch_comments',
			'permission_callback' => '__return_true',
			'args'                => array(
				'per_page' => array(
					'type'             => 'integer',
					'exclusiveMinimum' => false,
					'minimum'          => 1,
					'exclusiveMaximum' => false,
					'maximum'          => 100,
					'require'          => false,
					'default'          => 100,
				),
				'page'     => array(
					'type'             => 'integer',
					'exclusiveMinimum' => false,
					'minimum'          => 1,
					'require'          => false,
					'default'          => 1,
				),
				'offset'   => array(
					'type'             => 'integer',
					'exclusiveMinimum' => false,
					'minimum'          => 0,
					'require'          => false,
					'default'          => 0,
				),
			),
		),
		array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'mm_rate_comments',
			'permission_callback' => function () {

				return is_user_logged_in();
			},
			'args'                => array(
				'comments' => array(
					'type'              => 'array',
					'require'           => true,
					'items'             => array(
						'type'       => 'object',
						'properties' => array(
							'id'     => array(
								'type'             => 'integer',
								'exclusiveMinimum' => false,
								'minimum'          => 1,
								'require'          => true,
							),
							'rating' => array(
								'type'             => 'integer',
								'exclusiveMinimum' => false,
								'minimum'          => - 1,
								'exclusiveMaximum' => false,
								'maximum'          => 1,
								'require'          => true,
							),
						),
					),
					'validate_callback' => function ( $param, $request, $key ) {

						# sanitize first
						$param = rest_parse_request_arg( $param, $request, $key );

						if ( is_wp_error( $param ) ) {
							return $param;
						}

						foreach ( $param as $key => $comment_object ) {
							if ( ! get_comment( $comment_object['id'] ) instanceof WP_Comment ) {
								return new WP_Error(
									'mm_rest_validate_comments',
									__( 'A comment with this comment_id does not exist.', 'rest-rate' ),
									array( 'comment_id' => $comment_object['id'] )
								);
							}

							if ( 0 === intval( $comment_object['rating'] ) ) {
								return new WP_Error(
									'mm_rest_validate_comments',
									__( 'The rating cannot be zero.', 'rest-rate' ),
									array( 'comment_id' => $comment_object['id'] )
								);
							}
						}

						return true;
					},
				),
			),
		),

	) );
}


/**
 * Rate multiple comments.
 *
 * @param \WP_REST_Request $request
 *
 * @return \WP_Error|\WP_REST_Response
 */
function mm_rate_comments( $request ) {

	$comments_with_ratings = $request->get_param( 'comments' );

	# Do something.

	return rest_ensure_response( [] );
}


/**
 * Fetch comments with their ratings.
 * 
 * @param \WP_REST_Request $request
 *
 * @return \WP_Error|\WP_REST_Response
 */
function mm_fetch_comments( $request ) {

	$params = $request->get_params();

	return rest_ensure_response( [] );
}
