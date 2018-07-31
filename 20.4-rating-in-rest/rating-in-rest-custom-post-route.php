<?php
/*
Plugin Name: Rating in REST
Description: Custom POST-Route.
*/

add_action( 'rest_api_init', 'mm_rest_init' );

function mm_rest_init() {

	register_rest_route( 'rating_plugin/v1', '/rate', array(
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

			# Die Kommentar-ID.
			'comment_id' => array(
				# Der Typ.
				'type'              => 'integer',

				# Beschreibung
				'description'       => __( 'The comment ID.', 'rest-rate' ),

				# Diese Variable muss vorhanden sein um das Rating durchzuführen.
				'require'           => true,

				# Validierung (Überprüfung, ob der Kommentar mit der Kommentar-ID existiert).
				'validate_callback' => 'mm_rest_is_comment',

				# Säuberung: die Kommentar-ID kann nur eine positive Ganzzahl sein.
				'sanitize_callback' => function ( $param, $request, $key ) {

					return absint( $param );
				},
			),

			# Das Rating.
			'rating'     => array(
				#Der Typ.
				'type'              => 'integer',

				# Beschreibung
				'description'       => __( 'The actual rating. Can be +1 or -1', 'rest-rate' ),

				# Diese Variable muss vorhanden sein um das Rating durchzuführen.
				'require'           => true,

				# Validierung: nur -1 oder 1 ist erlaubt.
				'validate_callback' => function ( $param, $request, $key ) {

					$rating = mm_rest_sanitize_rating( $param, $request, $key );

					if ( 0 === $rating ) {
						return new WP_Error(
							'rest_rating_rate_error',
							__( 'Rating cannot be zero.', 'rest-rate' )
						);
					}

					return true;
				},

				# Säuberung: nur -1 oder 1 ist erlaubt.
				'sanitize_callback' => 'mm_rest_sanitize_rating',
			),
		),
	) );
}

/**
 * Sanitizes the rating.
 *
 * @param mixed            $param
 * @param \WP_REST_Request $request
 * @param string           $key
 *
 * @return int
 */
function mm_rest_sanitize_rating( $param, $request, $key ) {

	$rating = intval( $param );

	if ( $rating > 0 ) {
		return 1;
	}

	if ( $rating < 0 ) {
		return - 1;
	}

	return 0;
}

/**
 * Check if the current comment_id is a valid comment.
 *
 * @param mixed            $param
 * @param \WP_REST_Request $request
 * @param string           $key
 *
 * @return bool
 */
function mm_rest_is_comment( $param, $request, $key ) {

	$comment_id = absint( $param );

	return get_comment( $comment_id ) instanceof WP_Comment;
}

/**
 * @param \WP_REST_Request $request
 *
 * @return \WP_Error|\WP_REST_Response
 */
function mm_rate_comment( $request ) {

	# Variablen abrufen.
	$comment_id = $request->get_param( 'comment_id' );
	$rating     = $request->get_param( 'rating' );

	# Aktulles Rating abrufen.
	$current_rating = intval( get_comment_meta( $comment_id, 'comment_karma', true ) );

	# Neues Rating berechnen.
	$new_rating = $current_rating + $rating;

	# Neues Rating in die Datenbank schreiben.
	$updated = update_comment_meta( $comment_id, 'comment_karma', $new_rating );

	# Fehler ausgeben, falls obiges nicht klappte.
	if ( false === $updated ) {
		return new WP_Error(
			'rest_rating_rate_error',
			__( 'Rating could not be updated.', 'rest-rate' ),
			array(
				'comment_id' => $comment_id,
				'rating'     => $rating,
				'new_rating' => $new_rating,
			)
		);
	}

	# Individuelle Rückgabe.
	return rest_ensure_response( array(
		'comment_id' => $comment_id,
		'rating'     => $new_rating,
	) );
}
