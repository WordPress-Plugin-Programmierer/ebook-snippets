<?php
/*
Plugin Name: sprintf() zur Übersetzung nutzen
*/

$count = wp_count_posts( 'post' );

$trans = sprintf(
	__( 'You have %u published posts.', 'mm_trans' ),
	$count->publish
);

echo $trans;