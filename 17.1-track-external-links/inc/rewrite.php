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

		add_action( 'init', [ $this, 'add_rewrite_rules' ] );
		add_action( 'send_headers', [ $this, 'perform_redirect' ], 10, 1 );
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
	}


	/**
	 * Performs a redirect.
	 *
	 * @param \wp $wp
	 *
	 * @since 0.1.0
	 */
	public function perform_redirect( $wp ) {

		var_dump( $wp->query_vars );
	}

}
