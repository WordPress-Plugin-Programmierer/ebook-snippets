<?php
/*
Plugin Name: Der vollständige Code einer Settings Page
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
			'label_for' => 'mm_settings_section_1_field_1'
		)
	);

	register_setting( 'mm_settings_group', 'mm_settings_section_1_field_1', 'sanitize_text_field' );
}

function mm_settings_section_cb_1() {
	echo 'Dies ist die erste Section.';
}

function mm_settings_section_cb_1_field_1( $args ) {
	$value = get_option( 'mm_settings_section_1_field_1', $args['page_hook'] );
	echo '<input id="' . $args['label_for'] . '" class="regular-text" type="text" value="' . esc_attr( $value ) . '" name="mm_settings_section_1_field_1" />';
}