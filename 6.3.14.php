<?php
/*
Plugin Name: Übersetzungsbeispiel
*/

switch ( $post_type ) {
	case 'post':
		$trans = _nx_noop( 'post', 'posts', 'noun', 'mm_trans' );
		break;
	default:
		$trans = _nx_noop( 'page', 'pages', 'noun', 'mm_trans' );
}

echo _n( $trans['singular'], $trans['plural'], $count, 'mm_trans' );
