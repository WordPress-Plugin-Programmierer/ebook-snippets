<?php
/*
Plugin Name: apply_filters_ref_array()
*/

add_filter( 'posts_where', 'mm_posts_where', 10, 2 );

/**
 * @param string   $where
 * @param WP_Query $wp_query
 *
 * @return array
 */
function mm_posts_where( $where, $wp_query ) {
	global $wpdb;

	if ( $wp_query->is_home() ) {
		$where .= ' ' . $wpdb->prepare( 'AND post_author = %u', 1 );
	}

	return $where;
}
