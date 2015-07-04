<?php
/*
Plugin Name: Tax Query
*/

add_action( 'init', function () {
	/**
	 * @var wpdb $wpdb
	 */
	global $wpdb;

	$tax_query = array(
		array(
			'taxonomy' => 'genre',
			'field'    => 'slug',
			'terms'    => 'romane',
		)
	);

	$tax_sql = get_tax_sql( $tax_query, $wpdb->posts, 'ID' );

	$query = sprintf( 'SELECT * FROM %s %s WHERE 1=1 %s', $wpdb->posts, $tax_sql['join'], $tax_sql['where'] );

	var_dump( $query );

	$wpdb->get_results( $query );

} );
