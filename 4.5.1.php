<?php
/*
Plugin Name: Widget erstellen
*/

class MM_Mein_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'mm_mein_widget',
			'Mein Widget'
		);
	}
}