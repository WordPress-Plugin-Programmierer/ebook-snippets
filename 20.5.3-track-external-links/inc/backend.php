<?php

namespace f\tel;

if ( ! defined( 'ABSPATH' ) ) {
	die();
}


/**
 * Class Backend
 *
 * @since   0.1.0
 *
 * @package f\tel
 */
class Backend {

	/**
	 * @var \f\tel\Link_Table
	 * @since 0.1.0
	 */
	private $table;

	/**
	 * Backend constructor.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 9 );

		add_action( 'admin_init', array( $this, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_filter( 'set-screen-option', array( $this, 'set_screen_options' ), 10, 3 );
	}


	/**
	 * Registers JavaScript files.
	 *
	 * @since 0.3.0
	 */
	public function register_scripts() {
		wp_register_script(
			'track-external-links',
			plugin_dir_url( TEL_PLUGIN_FILE ) . 'js/backend.js',
			array( 'wp-api', 'wp-api-fetch', 'jquery' ),
			filemtime( plugin_dir_path( TEL_PLUGIN_FILE ) . 'js/backend.js' )
		);
	}


	/**
	 * Enqueues JavaScript files.
	 *
	 * @since 0.3.0
	 *
	 * @param string $hook_suffix
	 */
	public function enqueue_scripts( $hook_suffix ) {

		if ( 'toplevel_page_tel' !== $hook_suffix ) {
			return;
		}

		wp_enqueue_script( 'track-external-links' );

		$args = array(
			'total_records' => Link_Table::record_count(),
			'site_url'      => trailingslashit( site_url() ),
			'i18n'          => [
				'an_error_occurred' => __( 'An error occurred: %s', 'track-external-links' ),
				'edit'              => __( 'Edit' ),
				'delete'            => __( 'Delete' ),
			],
			'delete_link'   => add_query_arg( array(
				'page'     => esc_attr( $_REQUEST['page'] ),
				'action'   => 'delete',
				'id'       => '##id##',
				'_wpnonce' => wp_create_nonce( 'f/tel/link/delete' ),
			) ),
			'rest_url'      => rest_url(),
			'rest_nonce'    => wp_create_nonce( 'wp_rest' ),
		);

		wp_add_inline_script(
			'track-external-links',
			sprintf( 'var tel_script_constants = %s;', json_encode( (object) $args ) ),
			'before'
		);
	}


	/**
	 * Creates admin menu items.
	 *
	 * @since 0.1.0
	 */
	public function admin_menu() {

		$hook = add_menu_page(
			_x( 'Outgoing Links', 'Main page title', 'track-external-links' ),
			_x( 'Outgoing Links', 'Main menu title', 'track-external-links' ),
			'edit_posts',
			'tel',
			array( $this, 'links_page' ),
			'dashicons-admin-links'
		);

		add_action( 'load-' . $hook, array( $this, 'before_link_table_view' ) );
	}


	/**
	 * Tasks to do before table gets rendered.
	 *
	 * @since 0.1.0
	 */
	public function before_link_table_view() {

		require __DIR__ . '/link-table.php';

		$this->table = new Link_Table();
		$this->table->prepare_items();

		add_screen_option( 'per_page', array(
			'label'   => __( 'Links per page', 'track-external-links' ),
			'default' => 100,
			'option'  => 'links_per_page',
		) );
	}

	/**
	 * Prints the table view page.
	 *
	 * @since 0.1.0
	 */
	public function links_page() {

		?>
		<div class="wrap">
			<h1 class="wp-heading-inline"><?php echo get_admin_page_title(); ?></h1>

			<a class="page-title-action" href="#" onclick="return toggle_form()"><?php _e( 'Add new' ); ?></a>

			<hr class="wp-header-end"/>

			<?php settings_errors( 'tel' ); ?>

			<script>
              function toggle_form() {
                var form = document.getElementById( 'add_new_form' );
                if ( form.classList.contains( 'hidden' ) ) {
                  form.classList.remove( 'hidden' );

                  var form_input_elements = form.getElementsByTagName( 'input' );

                  form_input_elements[0].value = '';
                  form_input_elements[1].value = '';
                  form_input_elements[2].value = '';
                  form_input_elements[3].value = 'Save';
                }
                else {
                  form.classList.add( 'hidden' );
                }

                return false;
              }

              function edit_link( triggered_el ) {
                var id    = parseInt( triggered_el.getAttribute( 'data-id' ) );
                var $tr   = triggered_el.parentNode.parentNode.parentNode.parentNode;
                var title = $tr.getElementsByTagName( 'a' )[0].innerHTML;
                var link  = $tr.getElementsByTagName( 'a' )[0].getAttribute( 'href' );

                var form = document.getElementById( 'add_new_form' );
                if ( form.classList.contains( 'hidden' ) ) {
                  form.classList.remove( 'hidden' );
                }

                var form_input_elements = form.getElementsByTagName( 'input' );

                form_input_elements[0].value = id;
                form_input_elements[1].value = title;
                form_input_elements[2].value = link;
                form_input_elements[3].value = 'Update';

              }
			</script>

			<form id="add_new_form" class="hidden"
				  action="<?php echo esc_url( admin_url( 'admin.php?page=tel&action=new' ) ); ?>"
				  style="margin: 2em 0 0 0; border: 1px dotted #ccc; padding: 1em;" method="post">
				<input type="hidden" name="id" value=""/>
				<input class="regular-text code" type="text" required
					   placeholder="<?php _e( 'Enter Title...', 'track-external-links' ); ?>" name="title"/>
				<input class="regular-text code" type="url" required
					   placeholder="<?php _e( 'Enter Link...', 'track-external-links' ); ?>" name="link"/>
				<?php submit_button( __( 'Save', 'track-external-links' ), 'secondary', 'submit', false ); ?>
				<input type="hidden" name="_wpnonce"
					   value="<?php echo esc_attr( wp_create_nonce( 'f/tel/link/update' ) ); ?>"/>
			</form>

			<form action="<?php echo esc_url( admin_url( 'admin.php?page=tel' ) ); ?>" method="POST">
				<?php $this->table->display(); ?>
			</form>

			<script>var tel_single_row_template = <?php echo wp_json_encode( $this->table->get_row_template() ); ?>;
			</script>

		</div>

		<?php
	}


	/**
	 * Updates the screen options.
	 *
	 * @since 0.3.0
	 *
	 * @param bool   $status
	 * @param string $option
	 * @param mixed  $value
	 *
	 * @return mixed
	 */
	public function set_screen_options( $status, $option, $value ) {
		return $value;
	}
}


