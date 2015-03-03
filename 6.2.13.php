<?php
/*
Plugin Name: Übersetzungsbeispiel
*/

switch ( $post_type ) {
	case 'post':
		$trans = _n_noop( 'post', 'posts', 'mm_trans' );
		break;
	default:
		$trans = _n_noop( 'page', 'pages', 'mm_trans' );
}

echo _n( $trans['singular'], $trans['plural'], $count, 'mm_trans' );
