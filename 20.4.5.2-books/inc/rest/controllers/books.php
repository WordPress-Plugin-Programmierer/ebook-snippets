<?php


/**
 * Class MM_REST_Books_Controller.
 */
class MM_REST_Books_Controller extends WP_REST_Posts_Controller {

	/**
	 * MM_REST_Books_Controller constructor.
	 *
	 * @param string $post_type
	 */
	public function __construct( $post_type ) {
		parent::__construct( $post_type );
	}
}