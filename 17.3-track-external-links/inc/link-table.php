<?php

namespace f\tel;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Class Link_Table
 *
 * @since 0.1.0
 *
 * @package f\affiliate
 */
class Link_Table extends \WP_List_Table {

	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		parent::__construct( [
			'singular' => __( 'Link', 'track-external-links' ),
			'plural'   => __( 'Links', 'track-external-links' ),
			'ajax'     => false,
		] );

	}

	/**
	 * Retrieve links data from the database
	 *
	 * @param int $per_page
	 * @param int $page_number
	 *
	 * @since 0.1.0
	 *
	 * @return mixed
	 */
	public static function get_links( $per_page = 5, $page_number = 1 ) {

		global $wpdb;

		$sql = "SELECT * FROM {$wpdb->prefix}outgoing_links";

		if ( ! empty( $_REQUEST['orderby'] ) ) {
			$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
			$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
		} else {
			$sql .= ' ORDER BY id DESC';
		}

		$sql .= " LIMIT $per_page";

		$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;

		$result = $wpdb->get_results( $sql, 'ARRAY_A' );

		return $result;
	}


	/**
	 * Delete a link.
	 *
	 * @since 0.1.0
	 *
	 * @param int $id link ID.
	 */
	public static function delete_link( $id ) {

		global $wpdb;

		$wpdb->delete(
			"{$wpdb->prefix}outgoing_links",
			[ 'id' => $id ],
			[ '%d' ]
		);
	}


	/**
	 * Returns the count of records in the database.
	 *
	 * @since 0.1.0
	 *
	 * @return null|string
	 */
	public static function record_count() {

		global $wpdb;

		$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}outgoing_links";

		return $wpdb->get_var( $sql );
	}


	/**
	 * Text displayed when no customer data is available
	 *
	 * @since 0.1.0
	 */
	public function no_items() {

		_e( 'No links found.', 'track-external-links' );
	}


	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	function column_title( $item ) {

		$title = ! empty( $item['title'] ) ? $item['title'] : __( 'Untitled', 'track-external-links' );


		$title = sprintf(
			'<a href="%1$s" target="_blank">%2$s</a>',
			esc_url( $item['link'] ),
			esc_html( $title )
		);

		$delete_url = add_query_arg( array(
			'page'     => esc_attr( $_REQUEST['page'] ),
			'action'   => 'delete',
			'id'       => absint( $item['id'] ),
			'_wpnonce' => wp_create_nonce( 'f/tel/link/delete' ),
		) );

		$actions = [
			'edit'   => sprintf(
				'<a href="#" onclick="return edit_link(this)" data-id="%d">%s</a>',
				absint( $item['id'] ),
				__( 'Edit' )
			),
			'delete' => sprintf(
				'<a href="%s">%s</a>',
				esc_url( $delete_url ),
				__( 'Delete' )
			),
		];

		return $title . $this->row_actions( $actions );
	}


	/**
	 * Render a column when no column specific method exists.
	 *
	 * @param array  $item
	 * @param string $column_name
	 *
	 * @since 0.1.0
	 *
	 * @return mixed
	 */
	public function column_default( $item, $column_name ) {

		$value = '-';

		if ( isset( $item[ $column_name ] ) && is_scalar( $item[ $column_name ] ) ) {
			$value = $item[ $column_name ];
		}

		if ( 'link' === $column_name ) {
			$value = sprintf( '<a href="%1$s" target="_blank">%1$s</a>', esc_url( $item['link'] ) );
		}

		if ( 'slug' === $column_name ) {
			$link  = sprintf( '%s/out/%s/', untrailingslashit( site_url() ), esc_attr( $item['slug'] ) );
			$value = sprintf( '<a href="%1$s" target="_blank">%1$s</a>', $link );
		}

		return $value;
	}


	/**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @since 0.1.0
	 *
	 * @return string
	 */
	function column_cb( $item ) {

		return sprintf(
			'<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['id']
		);
	}


	/**
	 *  Associative array of columns
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function get_columns() {

		return [
			'cb'    => '<input type="checkbox" />',
			'title' => __( 'Link Title', 'track-external-links' ),
			'slug'  => __( 'Outgoing Link', 'track-external-links' ),
			'link'  => __( 'Going to...', 'track-external-links' ),
		];
	}


	/**
	 * Columns to make sortable.
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function get_sortable_columns() {

		$sortable_columns = array(
			'title' => array( 'title', false ),
			'link'  => array( 'link', false ),
			'slug'  => array( 'slug', false ),
		);

		return $sortable_columns;
	}


	/**
	 * Returns an associative array containing the bulk action.
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function get_bulk_actions() {

		$actions = [
			'bulk-delete' => __( 'Delete' ),
		];

		return $actions;
	}


	/**
	 * Handles data query and filter, sorting, and pagination.
	 *
	 * @since 0.1.0
	 */
	public function prepare_items() {

		$this->_column_headers = array(
			$this->get_columns(),
			array(),
			$this->get_sortable_columns(),
		);

		/** Process bulk action */
		$this->process_bulk_action();

		$per_page     = $this->get_items_per_page( 'links_per_page', 50 );
		$current_page = $this->get_pagenum();
		$total_items  = self::record_count();

		$this->set_pagination_args( [
			'total_items' => $total_items,
			'per_page'    => $per_page,
		] );


		$this->items = self::get_links( $per_page, $current_page );
	}


	/**
	 * Processes a bulk action.
	 *
	 * @since 0.1.0
	 */
	public function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if ( 'delete' === $this->current_action() ) {

			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'f/tel/link/delete' ) ) {
				wp_die( __( 'You are not allowed to do this.', 'track-external-links' ) );
			} else {
				self::delete_link( absint( $_GET['id'] ) );

				$redirect_url = remove_query_arg( array( '_wpnonce', 'action', 'id' ) );
				wp_redirect( esc_url( $redirect_url ) );
				exit;
			}

		}

		if ( 'new' === $this->current_action() ) {
			if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'f/tel/link/update' ) ) {
				add_settings_error( 'tel', 'new_or_update', __( 'You are not allowed to do this.', 'track-external-links' ) );

				return;
			}

			call_user_func( function () {

				if ( ! isset( $_POST['title'] ) || ! isset( $_POST['link'] ) ) {
					add_settings_error( 'tel', 'new', __( 'Please enter a title and a link', 'track-external-links' ) );

					return;
				}

				if ( empty( $_POST['title'] ) || empty( $_POST['link'] ) ) {
					add_settings_error( 'tel', 'new', __( 'Please enter a title and a link', 'track-external-links' ) );

					return;
				}

				$is_update = isset( $_POST['id'] ) && ! empty( $_POST['id'] ) && intval( $_POST['id'] ) > 0;

				global $wpdb;

				if ( $is_update ) {
					$id      = intval( $_POST['id'] );
					$updated = $wpdb->update(
						$wpdb->prefix . 'outgoing_links',
						array(
							'title' => sanitize_text_field( $_POST['title'] ),
							'link'  => esc_url_raw( $_POST['link'] ),
						),
						array(
							'id' => $id,
						),
						array( '%s', '%s' ),
						array( '%d' )
					);

					if ( $updated > 0 ) {
						add_settings_error( 'tel', 'update', __( 'Link updated!', 'track-external-links' ), 'updated' );

						return;
					} else {
						add_settings_error( 'tel', 'update', __( 'Link not updated. Maybe error or nothing has changed.', 'track-external-links' ), 'error' );

						return;
					}
				} else {
					$inserted = $wpdb->insert(
						$wpdb->prefix . 'outgoing_links',
						array(
							'title' => sanitize_text_field( $_POST['title'] ),
							'link'  => esc_url_raw( $_POST['link'] ),
							'slug'  => sanitize_key( $_POST['title'] ),
						),
						array( '%s', '%s' )
					);

					if ( 1 === $inserted ) {
						add_settings_error( 'tel', 'new', __( 'Link saved!', 'track-external-links' ), 'updated' );

						return;
					} else {
						add_settings_error( 'tel', 'new', __( 'Link could not be saved!', 'track-external-links' ), 'error' );

						return;
					}
				}

			} );
		}

		// If the delete bulk action is triggered
		if ( ( isset( $_POST['action'] ) && $_POST['action'] == 'bulk-delete' )
		     || ( isset( $_POST['action2'] ) && $_POST['action2'] == 'bulk-delete' )
		) {

			$delete_ids = esc_sql( $_POST['bulk-delete'] );

			// loop over the array of record IDs and delete them
			foreach ( $delete_ids as $id ) {
				self::delete_link( $id );

			}

			wp_redirect( esc_url( add_query_arg( [] ) ) );
			exit;
		}
	}
}
