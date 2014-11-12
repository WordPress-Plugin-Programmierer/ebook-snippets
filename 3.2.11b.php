<?php
/*
Plugin Name: Übergabe Hook Array innerhalb einer Klasse
*/

class MM_Test {

	public function __construct() {
		remove_action( 'wp_head', 'wp_generator' );
		add_action( 'wp_head', array( &$this, 'wp_head' ) );
	}

	public function wp_head() {
		echo '<meta name="generator" content="Unknown" />';
	}

}

$mm_test = new MM_Test();