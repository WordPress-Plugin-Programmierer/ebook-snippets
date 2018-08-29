<?php

add_action( 'rest_api_init', 'mm_rest_api_init' );

function mm_rest_api_init() {
	include __DIR__ . '/rest/controllers/books.php';
}

