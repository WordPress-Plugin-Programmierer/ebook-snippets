<?php
/*
Plugin Name: the_content Filter
*/

add_filter( 'the_content', 'mm_the_content' );
function mm_the_content( $content ) {
	return $content . ' - Mein angehängter Text';
}

?>