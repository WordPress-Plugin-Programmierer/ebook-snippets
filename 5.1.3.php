<?php
/*
Plugin Name: Settings API und Nonces Test
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

		<form action="<?php echo admin_url( 'options.php' ); ?>" method="post">
			<?php
			global $mm_page_hook;
			settings_fields( 'mm_settings_group' );
			do_settings_sections( $mm_page_hook );
			submit_button();
			?>

		</form>
	</div>
	<?php
}

add_action( 'admin_init', 'mm_register_settings' );

function mm_register_settings() {
	global $mm_page_hook;
	add_settings_section(
		'mm_settings_section_1',
		'Erste Settings Section',
		'mm_settings_section_cb_1',
		$mm_page_hook
	);

	add_settings_field(
		'mm_settings_section_1_field_1',
		'Feld 1',
		'mm_settings_section_cb_1_field_1',
		$mm_page_hook,
		'mm_settings_section_1',
		array(
			'page_hook' => $mm_page_hook,
			'label_for' => 'mm_settings_section_1_field_1',
		)
	);

	register_setting( 'mm_settings_group', 'mm_settings_section_1_field_1', 'sanitize_text_field' );
}

function mm_settings_section_cb_1() {
	echo 'Dies ist die erste Section.';
}

function mm_settings_section_cb_1_field_1( $args ) {
	$value = get_option( 'mm_settings_section_1_field_1', $args['page_hook'] );

	printf(
		'<input id="%s" class="regular-text" type="text" value="%s" name="mm_settings_section_1_field_1" />',
		esc_attr( $args['label_for'] ),
		esc_attr( $value )
	);

	$url = admin_url( 'options-general.php?page=mm-meins-unter-1&mm_action=delete_settings' );
	$url = wp_nonce_url(
	// die eigentliche URL
		$url,
		// der Name der Action
		'mm_delete_settings',
		// die Bezeichnung der Variablen die die Nonce beinhalten soll
		'mm_nonce' );

	printf( '<a class="button" style="color: red;" href="%s">Feld zurücksetzen</a>', esc_url( $url ) );
}


add_action( 'admin_init', function () {
	global $mm_page_hook;
	add_action( 'load-' . $mm_page_hook, 'mm_action_remove_settings' );
} );

function mm_action_remove_settings() {

	// Keine Action ausführen, wenn der GET-Parameter nicht gesetzt ist
	if ( ! isset( $_GET['mm_action'] ) ) {
		return;
	}

	// löschen nicht ausführen, wenn der GET-Parameter nicht 'delete_settings' enthält
	if ( 'delete_settings' != $_GET['mm_action'] ) {
		return;
	}

	check_admin_referer(
	// Der Name der Action
		'mm_delete_settings',
		// Die Bezeichnung der Variablen nach der in $_GET gesucht werden soll
		'mm_nonce'
	);

	if ( delete_option( 'mm_settings_section_1_field_1' ) ) {
		add_settings_error( '', 0, 'Feld wurde zurück gesetzt.', 'updated' );
	} else {
		add_settings_error( '', 0, 'Feld konnte nicht zurück gesetzt werden!', 'error' );
	}

}