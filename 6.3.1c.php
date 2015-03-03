<?php
/*
Plugin Name: sprintf() zur Übersetzung nutzen
*/

$count = wp_count_posts( 'post' );

$trans = sprintf(
	__( 'You have %2$u published and %1$u scheduled posts.', 'mm_trans' ),
	$count->future,
	$count->publish
);

echo $trans;