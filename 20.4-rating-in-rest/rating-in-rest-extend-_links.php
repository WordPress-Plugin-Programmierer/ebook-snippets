<?php
/*
Plugin Name: Rating in REST
Description: Extend _links in comments.
*/

add_filter( 'rest_prepare_comment', 'mm_rest_comment', 10, 3 );

/**
 * Extend _links in REST-Response.
 *
 * @param \WP_REST_Response $response
 * @param \WP_Comment       $comment
 * @param \WP_REST_Request  $request
 *
 * @return \WP_REST_Response
 */
function mm_rest_comment( $response, $comment, $request ) {

	$response->add_link(
		'https://my-rating-plugin.com/rating',
		rest_url( "/rating_plugin/v1/comment/{$comment->comment_ID}/ratings" )
	);

	return $response;
}


add_filter( 'rest_response_link_curies', 'mm_rest_curies' );

/**
 * Extend curies parameter in _links array.
 *
 * @param array $curies
 *
 * @return array
 */
function mm_rest_curies( $curies ) {

	$curies[] = array(
		'name'      => 'rating_plugin',
		'href'      => 'https://my-rating-plugin.com/{rel}',
		'templated' => true,
	);

	return $curies;
}
