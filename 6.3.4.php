<?php
/*
Plugin Name: vprintf() zur Übersetzung nutzen
*/

$count = wp_count_posts( 'post' );

vprintf(
	__( 'You have %2$u published and %1$u scheduled posts.', 'mm_trans' ),
	array(
		$count->future,
		$count->publish
	)
);

// Der "echo" Befehl entfällt