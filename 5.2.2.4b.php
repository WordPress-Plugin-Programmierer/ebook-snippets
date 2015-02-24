<?php
/*
Plugin Name: Freigabe von Beiträgen trotz eingeschränkte Rechte
*/

add_filter( 'map_meta_cap', function ( $caps, $cap, $user_id, $args ) {

	// Prüfen, ob die primitive Capability 'edit_post' gefordert wird.
	if ( 'edit_post' !== $cap ) {
		return $caps;
	}

	// Abbrechen, wenn die Post-ID nicht mitgeliefert wurde.
	if ( ! isset( $args[0] ) ) {
		return $caps;
	}

	// Die Post-ID
	$post_id = $args[0];

	// wenn ein Autor versucht, einen Artikel zu bearbeiten, der ihm nicht gehört,
	// dann erlaube es trotzdem. Jedoch nur für den Artikel mit ID 123
	if ( in_array( 'edit_others_posts', $caps ) && 123 == $post_id ) {
		$caps = array_diff( $caps, array( 'edit_others_posts' ) );
		return $caps;
	}

	return $caps;
}, 10, 4 );