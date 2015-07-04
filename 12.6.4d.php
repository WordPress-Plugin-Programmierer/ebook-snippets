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
		'relation' => 'AND',
		array(
			'taxonomy' => 'genre',
			'field'    => 'name',
			'terms'    => array( 'Religion', 'Politik' ),
			'operator' => 'NOT IN'
		),
		array(
			'taxonomy' => 'publisher',
			'field'    => 'name',
			'terms'    => 'Campus',
		),
	);

	$tax_sql = get_tax_sql( $tax_query, $wpdb->posts, 'ID' );

	var_dump( $tax_sql );

	$query = sprintf( 'SELECT * FROM %s %s WHERE 1=1 %s', $wpdb->posts, $tax_sql['join'], $tax_sql['where'] );

	var_dump( $query );

	$wpdb->get_results( $query );

} );
