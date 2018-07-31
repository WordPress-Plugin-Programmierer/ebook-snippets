<?php
/*
Plugin Name: Rating in REST
Description: Custom POST-Route with array variable.
*/

add_action( 'rest_api_init', 'mm_rest_init' );

function mm_rest_init() {

	register_rest_route( 'rating_plugin/v1', '/ratings', array(
		# Diese Route hat einen Endpunkt, nämlich POST (WP_REST_Server::CREATABLE = POST)
		'methods'             => WP_REST_Server::CREATABLE,

		# Die Funktion, die das Rating letztlich vornimmt.
		'callback'            => 'mm_rate_comment',

		# Zugriffsberechtigung in Erfahrung bringen.
		'permission_callback' => function () {

			# Nur eingeloggte Benutzer können Bewertungen abgeben
			return is_user_logged_in();
		},

		# Liste der Variablen, die per POST übergeben werden.
		'args'                => array(

			'comments' => array(
				'type'              => 'array',
				'require'           => true,
				'items'             => array(
					'type' => 'integer',
				),
				'validate_callback' => function ( $param, $request, $key ) {

					$param = mm_rest_sanitize_comments( $param, $request, $key );

					if ( is_wp_error( $param ) ) {
						return $param;
					}

					foreach ( $param as $comment_id ) {
						if ( ! get_comment( $comment_id ) instanceof WP_Comment ) {
							return new WP_Error(
								'mm_rest_validate_comments',
								__( 'A comment with this comment_id does not exist.', 'rest-rate' ),
								array( 'comment_id' => $comment_id )
							);
						}
					}

					return $param;
				},
				'sanitize_callback' => 'mm_rest_sanitize_comments',
			),

		),
	) );
}

/**
 * Sanitizes an array of comments.
 *
 * @param mixed            $param
 * @param \WP_REST_Request $request
 * @param string           $key
 *
 * @return array|\WP_Error
 */
function mm_rest_sanitize_comments( $param, $request, $key ) {

	if ( ! is_array( $param ) ) {
		return new WP_Error(
			'mm_rest_validate_comments',
			__( '', 'rest-rate' )
		);
	}

	array_walk( $param, 'absint' );

	return $param;
}

/**
 * @param \WP_REST_Request $request
 *
 * @return \WP_Error|\WP_REST_Response
 */
function mm_rate_comment( $request ) {

	$comments = $request->get_param( 'comments' );

	# Do something.

	return rest_ensure_response( [] );
}
