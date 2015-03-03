<?php
/*
Plugin Name: ABC-Plugin
Plugin URI: http://my-website.com/abc-plugin/
Description: This plugin displays ABC.
Author: Max Mustermann
Author URI: http://my-website.com/
Version: 1.0.0
Text Domain: abc
Domain Path: /langs/
*/

load_plugin_textdomain( 'abc', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );


add_action( 'admin_menu', 'mm_admin_menu' );

function mm_admin_menu() {
	add_menu_page(
		__( 'My Title', 'abc' ),
		__( 'My Menu', 'abc' ),
		'manage_options',
		'mm-meins',
		'mm_main_page_render',
		plugins_url( 'pacman.png', __FILE__ )
	);

	add_submenu_page(
		'mm-meins',
		__( 'My Subheading Title', 'abc' ),
		__( 'Submenu', 'abc' ),
		'manage_options',
		'mm-meins-unter-1',
		'mm_sub1_page_render'
	);
}

function mm_main_page_render() {
	?>
	<h1><?php _e( 'My Title', 'abc' ); ?></h1>
	<ul>
		<li><?php _e( 'This is a normal sentence.', 'abc' ); ?></li>
		<li>
			<button class="button"><?php _ex( 'Button', 'Button label', 'abc' ); ?></button>
		</li>
		<li><?php echo _n( 'You have one post.', 'You have far more posts.', count( wp_count_posts( 'post' ) ), 'abc' ) ?></li>
	</ul>
<?php
}

function mm_sub1_page_render() {
	echo '<h1>' . __( 'My Subheading Title', 'abc' ) . '</h1>';
}
