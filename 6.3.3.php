<?php
/*
Plugin Name: vsprintf() zur Übersetzung nutzen
*/

$count = wp_count_posts( 'post' );

$trans = vsprintf(
	__( 'You have %2$u published and %1$u scheduled posts.', 'mm_trans' ),
	array(
		$count->future,
		$count->publish
	)
);

echo $trans;