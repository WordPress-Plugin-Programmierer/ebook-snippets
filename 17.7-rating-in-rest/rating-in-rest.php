<?php
/*
Plugin Name: Rating in REST-API
*/

add_action( 'init', function () {

	register_meta( 'comment', 'rating', array(
		'type'              => 'integer',
		'description'       => __( 'The total rating for this comment.', 'plugin' ),
		'single'            => true,
		'sanitize_callback' => 'intval',
		'show_in_rest'      => true,
	) );

} );
