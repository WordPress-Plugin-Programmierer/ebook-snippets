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
		add_filter( 'rest_prepare_book', [ $this, 'manipulate_item' ], 10, 2 );
	}

	/**
	 * Changes author description.
	 *
	 * @return array
	 */
	public function get_item_schema() {
		$schema = parent::get_item_schema();

		if ( isset( $schema['properties']['author'] ) ) {
			$schema['properties']['author']['description'] = __( 'The ID of the author of the book.', 'mm-rest-example' );
		}


		return $schema;
	}

	/**
	 * Manipulates the response to match our purposes.
	 *
	 * @param WP_REST_Response $response
	 * @param WP_Post          $post
	 *
	 * @return WP_REST_Response
	 */
	public function manipulate_item( $response, $post ) {

		$data = $response->get_data();

		$book_author_id = get_post_meta( $post->ID, 'book_author', true );
		$data['author'] = $book_author_id;

		$response->set_data( $data );

		return $response;
	}

	/**
	 * Change CURIE links.
	 *
	 * @param WP_Post $post
	 *
	 * @return array
	 */
	protected function prepare_links( $post ) {
		$links = parent::prepare_links( $post );

		$book_author_id = get_post_meta( $post->ID, 'book_author', true );

		$links['author'] = array(
			'href'       => rest_url( 'wp/v2/book-authors/' . $book_author_id ),
			'embeddable' => true,
		);

		return $links;
	}
}