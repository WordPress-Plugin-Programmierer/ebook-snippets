<?php
/*
Plugin Name: Rating in REST
Description: Custom GET-Route with array variable.
*/

add_action( 'rest_api_init', 'mm_rest_init' );

function mm_rest_init() {

	register_rest_route( 'rating_plugin/v1', '/ratings', array(
		# Diese Route hat einen Endpunkt, nämlich GET (WP_REST_Server::READABLE = GET)
		'methods'             => WP_REST_Server::READABLE,

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
					'type'             => 'integer',
					'exclusiveMinimum' => false,
					'minimum'          => 1,
					'require'          => true,
				),
				'validate_callback' => function ( $param, $request, $key ) {

					# sanitize first
					$param = rest_parse_request_arg( $param, $request, $key );

					if ( is_wp_error( $param ) ) {
						return $param;
					}

					foreach ( $param as $key => $comment_id ) {
						if ( ! get_comment( $comment_id ) instanceof WP_Comment ) {
							return new WP_Error(
								'mm_rest_validate_comments',
								__( 'A comment with this comment_id does not exist.', 'rest-rate' ),
								array( 'comment_id' => $comment_id )
							);
						}
					}

					return true;
				},
			),

		),
	) );
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
