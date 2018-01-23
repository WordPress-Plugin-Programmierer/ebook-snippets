<?php
/*
  Plugin Name: Drafts for Friends
  Plugin URI: https://wp-plugin-erstellen.de
  Version: 0.1.0
  Author: Florian Simeth
  Author URI: https://florian-simeth.de
  Description: Allows to create links to draft posts.
  Text Domain: drafts-for-friends
  Domain Path: /languages
  License: GPL
 */

/**
 * Drafts for Friends Plugin.
 *
 * Allows to create links to draft posts.
 *
 * @since      0.1.0
 *
 * @package    WordPress
 * @subpackage drafts-for-friends
 */


add_action( 'admin_menu', 'dff_menus' );

/**
 * Adds the "Draft for Friends" submenu item.
 *
 * This functions adds the submenu item called "Drafts for friends" in posts.
 * It also adds a hook that allows to add new drafts to the list.
 *
 * @since 0.1.0
 *
 * @return void
 */
function dff_menus() {

	$hook = add_submenu_page(
		'edit.php',                                         # parent menu
		__( 'Drafts for Friends', 'drafts-for-friends' ),   # page title
		__( 'Drafts for Friends', 'drafts-for-friends' ),   # menu title
		'manage_options',                                   # capability
		'drafts-for-friends',                               # menu slug
		'dff_settings_page_render'                          # callable function
	);

	// hook into the page so that we can check for POST calls.
	add_action( 'load-' . $hook, 'dff_new_draft_create' );
	add_action( 'load-' . $hook, 'dff_scripts_backend' );
}


/**
 * Render the settings page.
 *
 * This function renders the settings page of the plugin. It shows a list
 * of released draft posts and a form that allows one to add drafts.
 *
 * @since 0.1.0
 *
 * @return void Outputs HTML code.
 */
function dff_settings_page_render() {

	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

		<?php
		/**
		 * Show the list of released posts.
		 */
		include( plugin_dir_path( __FILE__ ) . '/templates/released-posts.php' );

		/**
		 * Show the form to add new draft posts.
		 */
		include( plugin_dir_path( __FILE__ ) . '/templates/new-draft-form.php' );
		?>

	</div>
	<?php
}


/**
 * Output option-Elements for a HTML-select-field.
 *
 * This function outputs HTML option fields to use in a select box. The list includes
 * all draft posts that have not yet been released.
 *
 * @since 0.1.0
 *
 * @return void Outputs HTML code.
 */
function dff_draft_select_options() {

	$query = new WP_Query( array(
		'post_type'   => 'post',
		'post_status' => 'draft',
		'meta_query'  => array(
			array(
				'key'     => 'dff_key',
				'compare' => 'NOT EXISTS',
			),
		),
	) );

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			printf(
				'<option value="%d">%s</option>',
				get_the_ID(),
				esc_attr( get_the_title() )
			);
		}
	} else {
		printf(
			'<option value="0">%s</option>',
			esc_attr__( 'No drafts found.', 'drafts-for-friends' )
		);
	}
}


add_action( 'admin_action_dff_new_draft', 'dff_new_draft_create' );

/**
 * Adds a new entry to the release post list.
 *
 * This function process the form data that allows one to add a draft post to the release list.
 *
 * @since 0.1.0
 *
 * @return void
 */
function dff_new_draft_create() {

	// Stop if this page has no action.
	if ( ! isset( $_POST['action'] ) ) {
		return;
	}

	// check for the referer and the nonces.
	// check_admin_referer() will die() if the data is not correct.
	$nonce_check = check_admin_referer( 'dff_new_draft' );

	if ( ! $nonce_check ) {
		add_action( 'admin_notices', function () {

			?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'Sorry, you cannot create a new draft.', 'drafts-for-friends' ); ?></p>
			</div>
			<?php
		} );

		return;
	}

	// Get the actual post ID from the _POST array.
	$post_id = absint( $_POST['post_id'] ?? 0 ); // works in PHP > 7.0 only

	// Stop executing if there is not post ID.
	if ( empty( $post_id ) ) {
		add_action( 'admin_notices', function () {

			?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'Please select a valid draft post from the select box.', 'drafts-for-friends' ); ?></p>
			</div>
			<?php
		} );

		return;
	}

	// Add new post meta data and check if it returns TRUE.
	$is_saved = add_post_meta( $post_id, 'dff_key', uniqid() );

	// Show a notice if something went wrong.
	if ( ! $is_saved ) {
		add_action( 'admin_notices', function () {

			?>
			<div class="notice notice-error is-dismissible">
				<p><?php _e( 'Sorry, draft could not be released.', 'drafts-for-friends' ); ?></p>
			</div>
			<?php
		} );

		return;
	}

	// All done. Show success notice to the user.
	add_action( 'admin_notices', function () {

		?>
		<div class="notice notice-success is-dismissible">
			<p><?php _e( 'Draft has been released.', 'drafts-for-friends' ); ?></p>
		</div>
		<?php
	} );

}


add_filter( 'query_vars', 'dff_add_query_var' );

/**
 * Add 'dff_key' variable to query vars.
 *
 * This function adds 'dff_key' to the list of allowed query vars so that we can
 * use it later.
 *
 * @since 0.1.0
 *
 * @param array $vars The list of query vars.
 *
 * @return array The new list of query vars.
 */
function dff_add_query_var( $vars ) {

	$vars[] = 'dff_key';

	return $vars;
}


add_action( 'pre_get_posts', 'dff_intersect' );

/**
 * Checks if a non-logged-in user can see the post and hooks into the database query.
 *
 * This function checks if a non-logged-in user can see the post when the 'dff_key'
 * parameter has been added via the URL. For this we hook into the database query
 * by adding 'draft' to the post_status value and by adding a meta query.
 *
 * @since 0.1.0
 *
 * @param WP_Query $wp_query The current database query object.
 *
 * @return void
 */
function dff_intersect( $wp_query ) {

	// If this is not the main query, stop here.
	if ( ! $wp_query->is_main_query() ) {
		return;
	}

	// We only need to hook into this on post pages.
	if ( ! $wp_query->is_single ) {
		return;
	}

	$key = get_query_var( 'dff_key' );

	// Stop here if there is no key provided.
	if ( empty( $key ) ) {
		return;
	}

	// Get all post_status values (maybe other plugins hook into that, too).
	$post_stati = (array) get_query_var( 'post_status' );

	// Add post_status 'draft'.
	$post_stati[] = 'draft';

	// Remove empty values.
	$post_stati = array_filter( $post_stati );

	// Set the new post_status value.
	set_query_var( 'post_status', $post_stati );

	// Read the meta query (if there are any).
	$meta_queries = (array) get_query_var( 'meta_query' );

	// Add a new meta query.
	$meta_queries[] = array(
		'key'     => 'dff_key',
		'value'   => esc_sql( $key ),
		'compare' => '=',
	);

	// Filter empty meta queries.
	$meta_queries = array_filter( $meta_queries );

	// Set the new meta_query array.
	set_query_var( 'meta_query', $meta_queries );
}


add_action( 'publish_post', 'dff_delete_key_on_transition' );

/**
 * Deletes the 'dff_key' meta key on post transition.
 *
 * This function deletes the 'dff_key' meta value from the database if the
 * user switches the post status to 'publish'.
 *
 * @since 0.1.0
 *
 * @param int $post_id The post ID from the post that was transitioned.
 *
 * @return void
 */
function dff_delete_key_on_transition( $post_id ) {

	delete_post_meta( $post_id, 'dff_key' );
}


add_filter( 'wp_redirect', 'dff_redirect_remove_key' );

/**
 * Remove 'dff_key' parameter on redirects.
 *
 * This function removes the 'dff_key' parameter if WordPress performs a canonical redirect.
 * This usually happens when the URL changes (or if an author publishes a post).
 *
 * @since 0.1.0
 *
 * @param string $url The URL WordPress wants to redirect to.
 *
 * @return string The new redirect URL.
 */
function dff_redirect_remove_key( $url ) {

	$key = get_query_var( 'dff_key' );

	// Stop here if there is no key provided.
	if ( empty( $key ) ) {
		return $url;
	}

	// Check for a post ID.
	$post_id = get_query_var( 'p' );

	// Remove the query argument ('dff_key') if it's there.
	if ( 'draft' != get_post_status( $post_id ) ) {
		$url = remove_query_arg( 'dff_key', $url );
	}

	return $url;
}

add_action( 'init', 'dff_register_scripts' );

/**
 * Register scripts and styles needed in this plugin.
 *
 * @since 0.2.0
 */
function dff_register_scripts() {

	wp_register_script(
		'dff-manager',
		plugin_dir_url( __FILE__ ) . 'assets/js/manager.js',
		array( 'jquery' ),
		filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/manager.js' ),
		true
	);
}

/**
 * Enqueues JavaScript and CSS files.
 *
 * We enqueue our Scripts and Styles to allow users to manage their Drafts-for-Friends.
 *
 * @hooked load-$hook
 *
 * @since 0.2.0
 */
function dff_scripts_backend() {

	wp_enqueue_script( 'dff-manager' );
}


add_action( 'rest_api_init', 'register_rest_routes' );

function register_rest_routes() {

	register_rest_route( 'drafts-for-friends', '/posts', array(
		'methods'             => \WP_REST_Server::DELETABLE,
		'callback'            => 'dff_rest_delete',
		'permission_callback' => function ( $request ) {

			return current_user_can( 'manage_options' );
		},
		'args'                => array(
			'key' => array(
				'required'          => true,
				'sanitize_callback' => function ( $param ) {

					return sanitize_text_field( $param );
				},
				'validate_callback' => function ( $param, $request, $key ) {

					$key = sanitize_text_field( $param );

					global $wpdb;

					$ctn = $wpdb->get_var( $wpdb->prepare(
						"SELECT COUNT(*) FROM {$wpdb->postmeta} WHERE meta_key='dff_key' AND meta_value=%s",
						$key
					) );

					$ctn = absint( $ctn );

					if ( 1 !== $ctn ) {
						return new \WP_Error(
							'dff_rest_delete',
							__( 'This key does not exist.', 'drafts-for-friends' )
						);
					}

					return true;
				},
			),
		),
	) );
}


/**
 * Deletes a DFF entry.
 *
 * @since 0.2.0
 *
 * @param WP_REST_Request $request
 *
 * @return WP_REST_Response
 */
function dff_rest_delete( $request ) {

	$key = $request->get_param( 'key' );

	global $wpdb;

	$post_id = $wpdb->get_var( $wpdb->prepare(
		"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='dff_key' AND meta_value=%s",
		$key
	) );

	return rest_ensure_response( array(
		'deleted' => delete_post_meta( intval( $post_id ), 'dff_key' ),
	) );
}
