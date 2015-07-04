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
		'relation' => 'OR',
		array (
			'relation' => 'AND',
			array(
				'taxonomy' => 'genre',
				'field'    => 'slug',
				'terms'    => 'romane',
			),
			array(
				'taxonomy' => 'author',
				'field'    => 'slug',
				'terms'    => 'stephen-king',
			),
		),
		array (
			'relation' => 'AND',
			array(
				'taxonomy' => 'genre',
				'field'    => 'slug',
				'terms'    => 'sachbuecher',
			),
			array(
				'taxonomy' => 'publisher',
				'field'    => 'slug',
				'terms'    => 'o-reilly',
			),
		),
	);

	$tax_sql = get_tax_sql( $tax_query, $wpdb->posts, 'ID' );

	var_dump( $tax_sql );

	$query = sprintf( 'SELECT * FROM %s %s WHERE 1=1 %s', $wpdb->posts, $tax_sql['join'], $tax_sql['where'] );

	var_dump( $query );

	$wpdb->get_results( $query );

} );
