<?php
/*
Plugin Name: sprintf() zur Übersetzung nutzen
*/

$count = wp_count_posts( 'post' );

$trans = sprintf(
	__( 'You have %u published and %u scheduled posts.', 'mm_trans' ),
	$count->publish,
	$count->future
);

echo $trans;