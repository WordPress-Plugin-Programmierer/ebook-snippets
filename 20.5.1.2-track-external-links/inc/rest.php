<?php

namespace f\tel;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class REST
 * @package f\tel
 *
 * @since   0.2.0
 */
class REST extends \WP_REST_Controller {


	/**
	 * REST constructor.
	 * @since 0.2.0
	 */
	public function __construct() {
		$this->namespace = 'tel/v1';
		$this->rest_base = 'outgoing-links';
		$this->register_routes();
	}


	/**
	 * Registers all REST routes.
	 * @since 0.2.0
	 */
	public function register_routes() {
		register_rest_route( $this->namespace, '/' . $this->rest_base, array(
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_items' ),
				'permission_callback' => array( $this, 'get_items_permissions_check' ),
				'args'                => $this->get_collection_params(),
			),
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'create_item' ),
				'permission_callback' => array( $this, 'create_item_permissions_check' ),
				'args'                => $this->get_endpoint_args_for_item_schema( \WP_REST_Server::CREATABLE ),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
		) );

		register_rest_route( $this->namespace, '/' . $this->rest_base . '/(?P<id>[\d]+)', array(
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_item' ),
				'permission_callback' => array( $this, 'get_item_permissions_check' ),
			),
			array(
				'methods'             => \WP_REST_Server::DELETABLE,
				'callback'            => array( $this, 'delete_item' ),
				'permission_callback' => array( $this, 'delete_item_permissions_check' ),

			),
			array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => array( $this, 'update_item' ),
				'permission_callback' => array( $this, 'update_item_permissions_check' ),
				'args'                => $this->get_endpoint_args_for_item_schema( \WP_REST_Server::EDITABLE ),
			),
			'schema' => array( $this, 'get_public_item_schema' ),
			'args'   => array(
				'id' => array(
					'sanitize_callback' => function ( $id, $request, $parameter ) {
						return absint( $id );
					},
					'validate_callback' => function ( $id, $request, $parameter ) {
						return is_object( $this->get_link( absint( $id ) ) );
					},
				),
			),
		) );

	}


	/**
	 * Retrieves the query params for the posts collection.
	 *
	 * @since 0.2.0
	 *
	 * @return array
	 */
	public function get_collection_params() {
		$query_params = parent::get_collection_params();

		$query_params['context']['default'] = 'view';

		return $query_params;
	}

	/**
	 * Returns the item schema.
	 *
	 * @since 0.2.0
	 *
	 * @return array
	 */
	public function get_item_schema() {

		return array(
			'$schema'    => 'http://json-schema.org/draft-04/schema#',
			'title'      => $this->rest_base,
			'type'       => 'object',
			'properties' => array(
				'id' => array(
					'description' => __( 'Unique identifier for the object.', 'track-external-links' ),
					'type'        => 'integer',
					'context'     => array( 'view', 'edit' ),
					'readonly'    => true,
				),

				'title' => array(
					'description' => __( 'The title for the object.', 'track-external-links' ),
					'type'        => 'object',
					'context'     => array( 'view', 'edit' ),
					'arg_options' => array(
						'sanitize_callback' => '\sanitize_text_field',
						'validate_callback' => function ( $param ) {
							$title = sanitize_text_field( $param );

							return ! empty( $title );
						},
					),
				),

				'slug' => array(
					'description' => __( 'An alphanumeric identifier for the object unique to its type.', 'track-external-links' ),
					'type'        => 'string',
					'context'     => array( 'view', 'edit' ),
					'arg_options' => array(
						'sanitize_callback' => array( $this, 'sanitize_slug' ),
					),
					'readonly'    => true,
				),

				'link' => array(
					'description' => __( 'URL to the object.', 'track-external-links' ),
					'type'        => 'string',
					'format'      => 'uri',
					'context'     => array( 'view', 'edit' ),
				),

				'count' => array(
					'description' => __( 'How often the Link was clicked.', 'track-external-links' ),
					'type'        => 'integer',
					'context'     => array( 'view', 'edit' ),
					'readonly'    => true,
				),

			),
		);
	}


	/**
	 * @param \WP_REST_Request $request
	 *
	 * @since 0.2.0
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_items( $request ) {
		global $wpdb;

		$page_number = $request->get_param( 'page' );
		$per_page    = $request->get_param( 'per_page' );
		$offset      = $request->get_param( 'offset' );

		$sql = "SELECT * FROM {$wpdb->prefix}outgoing_links LIMIT {$per_page}";

		if ( $page_number > 1 ) {
			$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;
		} elseif ( $offset > 0 ) {
			$sql .= ' OFFSET ' . $offset;
		}

		// @todo Integrate search functionality

		$query_result = $wpdb->get_results( $sql );

		if ( ! is_array( $query_result ) ) {
			return new \WP_Error(
				'tel/rest/get_items',
				sprintf(
					__( 'Could not fetch any links. Database responded with the following error: %s', 'track-external-links' ),
					$wpdb->last_error
				)
			);
		}

		$links = array();

		foreach ( $query_result as $data ) {
			$link    = $this->prepare_item_for_response( $data, $request );
			$links[] = $this->prepare_response_for_collection( $link );
		}

		$response = rest_ensure_response( $links );

		$total_links = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}outgoing_links" );
		$max_pages   = ceil( $total_links / $per_page );

		$response->header( 'X-WP-Total', (int) $total_links );
		$response->header( 'X-WP-TotalPages', (int) $max_pages );

		$request_params = $request->get_query_params();
		$base           = add_query_arg( $request_params, rest_url( sprintf( '%s/%s', $this->namespace, $this->rest_base ) ) );

		if ( $page_number > 1 ) {
			$prev_page = $page_number - 1;

			if ( $prev_page > $max_pages ) {
				$prev_page = $max_pages;
			}

			$prev_link = add_query_arg( 'page', $prev_page, $base );
			$response->link_header( 'prev', $prev_link );
		}
		if ( $max_pages > $page_number ) {
			$next_page = $page_number + 1;
			$next_link = add_query_arg( 'page', $next_page, $base );

			$response->link_header( 'next', $next_link );
		}

		return $response;
	}


	/**
	 * Fetches a single link from the database.
	 *
	 * @since 0.2.0
	 *
	 * @param int $id
	 *
	 * @return null|object
	 */
	private function get_link( $id ) {
		global $wpdb;

		return $wpdb->get_row( $wpdb->prepare(
			"SELECT * FROM {$wpdb->prefix}outgoing_links WHERE id = %d",
			$id
		) );
	}


	/**
	 * Returns a single item.
	 *
	 * @since 0.2.0
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function get_item( $request ) {

		$link = $this->get_link( $request->get_param( 'id' ) );

		$link = $this->prepare_item_for_response( $link, $request );

		return rest_ensure_response( $link );
	}


	/**
	 * Creates an item.
	 *
	 * @since 0.2.0
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function create_item( $request ) {
		global $wpdb;

		$prepared_link = $this->prepare_item_for_database( $request );

		if ( is_wp_error( $prepared_link ) ) {
			return $prepared_link;
		}

		if ( isset( $prepared_link['id'] ) ) {
			return new \WP_Error(
				'tel/rest/insert',
				__( 'Please do not set the ID parameter.', 'track-external-links' )
			);
		}

		$inserted = $wpdb->insert(
			$wpdb->prefix . 'outgoing_links',
			$prepared_link,
			array( '%s', '%s', '%s' )
		);

		if ( false === $inserted ) {
			return new \WP_Error(
				'tel/rest/insert',
				sprintf(
					__( 'Could not insert link. Database responded with the following error: %s', 'track-external-links' ),
					$wpdb->last_error
				)
			);
		}

		$link = $this->get_link( $wpdb->insert_id );

		$request->set_param( 'context', 'edit' );

		$response = $this->prepare_item_for_response( $link, $request );
		$response = rest_ensure_response( $response );

		$response->set_status( 201 );

		$response->header(
			'Location',
			rest_url( sprintf( '%s/%s/%d', $this->namespace, $this->rest_base, $link->id ) )
		);

		return $response;
	}


	/**
	 * Updates a link.
	 *
	 * @since 0.2.0
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return mixed|\WP_Error|\WP_REST_Response
	 */
	public function update_item( $request ) {
		global $wpdb;

		$id = $request->get_param( 'id' );

		$prepared_link = $this->prepare_item_for_database( $request );

		if ( is_wp_error( $prepared_link ) ) {
			return $prepared_link;
		}

		natsort( $prepared_link );

		# do not update the id and count
		unset( $prepared_link['id'], $prepared_link['count'] );

		$updated = $wpdb->update(
			$wpdb->prefix . 'outgoing_links',
			$prepared_link,
			array( 'id' => $id ),
			array( '%s', '%s', '%s' ),
			array( '%d' )
		);

		if ( false === $updated ) {
			return new \WP_Error(
				'tel/rest/update',
				sprintf(
					__( 'Could not update link. Database responded with the following error: %s', 'track-external-links' ),
					$wpdb->last_error
				)
			);
		}

		$link = $this->get_link( $id );

		$request->set_param( 'context', 'edit' );

		$response = $this->prepare_item_for_response( $link, $request );
		$response = rest_ensure_response( $response );

		return $response;
	}


	/**
	 * Deletes one item.
	 *
	 * @since 0.2.0
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function delete_item( $request ) {
		global $wpdb;

		$id = $request->get_param( 'id' );

		$link = $this->get_link( $request->get_param( 'id' ) );

		$deleted = $wpdb->delete(
			"{$wpdb->prefix}outgoing_links",
			array( 'id' => $id ),
			array( '%d' )
		);

		if ( false === $deleted ) {
			return new \WP_Error(
				'tel/rest/delete',
				sprintf(
					__( 'Could not delete link. Database responded with the following error: %s', 'track-external-links' ),
					$wpdb->last_error
				)
			);
		}

		return rest_ensure_response( array(
			'deleted'  => $deleted >= 1,
			'previous' => $link
		) );
	}


	/**
	 * Prepares a single link for update or create.
	 *
	 * @param \WP_REST_Request $request
	 *
	 * @since 0.2.0
	 *
	 * @return array|\WP_Error
	 */
	protected function prepare_item_for_database( $request ) {

		$id = $request->get_param( 'id' );

		# check if we do an update and load initial values
		if ( ! empty( $id ) ) {
			$args = (array) $this->get_link( $id );
		} else {
			$args = array();
		}

		$title = $request->get_param( 'title' );

		if ( ! empty( $title ) ) {
			$args['title'] = $title;
		}

		$link = $request->get_param( 'title' );

		if ( ! empty( $link ) ) {
			$args['link'] = $link;
		}

		if ( ! empty( $args['title'] ) ) {
			$args['slug'] = sanitize_key( $args['title'] );
		}


		if ( empty( $args['title'] ) ) {
			return new \WP_Error(
				'tel/rest/item',
				__( 'Please enter a title.', 'track-external-links' )
			);
		}

		if ( empty( $args['link'] ) ) {
			return new \WP_Error(
				'tel/rest/item',
				__( 'Please enter an URL.', 'track-external-links' )
			);
		}

		return $args;
	}


	/**
	 * Prepares a single item for the response.
	 *
	 * @since 0.2.0
	 *
	 * @param object           $link
	 * @param \WP_REST_Request $request
	 *
	 * @return \WP_Error|\WP_REST_Response
	 */
	public function prepare_item_for_response( $link, $request ) {

		$link->id    = (int) $link->id;
		$link->count = (int) $link->count;

		$response = rest_ensure_response( (array) $link );

		$_links = $this->prepare_links( $link );

		$response->add_links( $_links );

		return $response;
	}


	/**
	 * Prepare _links in response.
	 *
	 * @since 0.2.0
	 *
	 * @param object $link
	 *
	 * @return array
	 */
	public function prepare_links( $link ) {
		$base = sprintf( '%s/%s', $this->namespace, $this->rest_base );

		// Entity meta.
		$links = array(
			'self'       => array(
				'href' => rest_url( trailingslashit( $base ) . $link->id ),
			),
			'collection' => array(
				'href' => rest_url( $base ),
			),
		);


		return $links;
	}


	/**
	 * @param \WP_REST_Request $request
	 *
	 * @since 0.2.0
	 *
	 * @return bool|\WP_Error
	 */
	public function get_items_permissions_check( $request ) {
		return true;
	}


	public function get_item_permissions_check( $request ) {
		return true;
	}


	public function create_item_permissions_check( $request ) {
		return current_user_can( 'edit_posts' );
	}


	public function update_item_permissions_check( $request ) {
		return current_user_can( 'edit_posts' );
	}


	public function delete_item_permissions_check( $request ) {
		return current_user_can( 'edit_posts' );
	}

}