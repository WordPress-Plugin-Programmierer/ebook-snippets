<?php

namespace f\tel;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Rewrite
 *
 * @package f\tel
 * @since 0.1.0
 */
class Rewrite {

	/**
	 * Rewrite constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'add_rewrite_rules' ), 10, 1 );
		add_action( 'send_headers', array( $this, 'perform_redirect' ), 10, 1 );
	}


	/**
	 * Adding rewrite rules.
	 *
	 * @since 0.1.0
	 */
	public function add_rewrite_rules() {

		add_rewrite_rule(
			'^out/([A-Za-z0-9\-_]+)/?', # Lowercase alphanumeric characters, dashes and underscores are allowed. @see sanitize_key().
			'index.php?tel_slug=$matches[1]',
			'top'
		);

		add_rewrite_tag( '%tel_slug%', '([A-Za-z0-9\-_]+)' );

	}


	/**
	 * Performs a redirect.
	 *
	 * @param \wp $wp
	 *
	 * @since 0.1.0
	 */
	public function perform_redirect( $wp ) {

		if ( ! isset( $wp->query_vars['tel_slug'] ) ) {
			return;
		}

		$slug = sanitize_key( $wp->query_vars['tel_slug'] );

		if ( empty( $slug ) ) {
			return;
		}

		global $wpdb;

		$link = $wpdb->get_var( $wpdb->prepare(
			"SELECT link FROM {$wpdb->prefix}outgoing_links WHERE slug = %s",
			$slug
		) );

		if ( is_null( $link ) ) {
			wp_redirect( site_url(), 301 );
		}

		$wpdb->query( $wpdb->prepare(
			"UPDATE `wp_outgoing_links` SET count = count + 1 WHERE slug = %s",
			$slug
		) );

		wp_redirect( $link, 302 );
	}

}
