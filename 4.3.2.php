<?php
/*
Plugin Name: Settings Page erstellen
*/
add_action( 'admin_menu', 'mm_admin_menu' );

function mm_admin_menu() {
	global $mm_page_hook;
	$mm_page_hook = add_submenu_page(
		'options-general.php',
		'Mein Untermenü-Titel',
		'Untermenü',
		'manage_options',
		'mm-meins-unter-1',
		'mm_settings_page_render'
	);
}

function mm_settings_page_render() {
	?>
	<div class="wrap">
		<h2><?php echo get_admin_page_title(); ?></h2>

		<form action="options.php" method="post">

		</form>
	</div>
<?php
}