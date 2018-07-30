<?php
/*
Plugin Name: Rating in REST
Description: Using <code>register_rest_field</code>
*/

add_action( 'rest_api_init', 'mm_init' );

function mm_init() {

	register_rest_field( 'comment', 'karma', [
		'get_callback'    => 'mm_get_karma',
		'schema'          => [
			'type'        => 'int',
			'description' => __( 'The overall rating of this comment.', 'rest-rating' ),
			'context'     => [ 'view', 'edit' ],
			'arg_options' => array(
				'sanitize_callback' => 'intval',
			),
		],
		'update_callback' => 'mm_update_karma',
	] );
}

function mm_get_karma( $object, $field_name, $request, $object_type ) {

	return intval( get_comment_meta( $object['id'], 'comment_' . $field_name, true ) );
}

function mm_update_karma( $field_value, $object, $field_name, $request, $object_type ) {

	$updated = update_comment_meta( $object->comment_ID, 'comment_' . $field_name, $field_value );

	if ( false === $updated ) {
		return new WP_Error(
			'mm_karma_update',
			__( 'An error occurred during updating the karma value.', 'rest-rating' ),
			[
				'value' => $field_value,
			]
		);
	}

	return true;
}
