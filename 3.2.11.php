<?php
/*
Plugin Name: Übergabe Hook Array
*/


class MM_Test {

	public static function wp_head() {
		echo '<meta name="generator" content="Unknown" />';
	}

}

add_action( 'wp_head', array( 'MM_Test', 'wp_head' ) );