<?php
/*
Plugin Name: printf() zur Übersetzung nutzen
*/

$count = wp_count_posts( 'post' );

printf(
	__( 'You have %u published and %u scheduled posts.', 'mm_trans' ),
	$count->publish,
	$count->future
);

// Der "echo" Befehl entfällt