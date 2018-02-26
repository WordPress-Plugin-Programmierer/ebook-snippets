<?php
/*
  Plugin Name: Weather Widget
  Plugin URI: https://wp-plugin-erstellen.de
  Version: 0.1.0
  Author: Florian Simeth
  Author URI: https://florian-simeth.de
  Description: A simple weather widget that shows the current temperature.
  Text Domain: weather-wi
  Domain Path: /languages
  License: GPL
 */


add_action( 'widgets_init', 'wwi_widget_init' );

/**
 * Register Widgets.
 *
 * @since 0.1.0
 */
function wwi_widget_init() {

	register_widget( 'WWI_Weather_Widget' );
}


add_action( 'wp_enqueue_scripts', 'wwi_enqueue_scripts' );

function wwi_enqueue_scripts() {

	wp_register_style(
		'wi-weather',
		plugin_dir_url( __FILE__ ) . 'assets/css/frontend.css',
		array(),
		filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/frontend.css' )
	);

	wp_enqueue_style( 'wi-weather' );
}

/**
 * Class WWI_Weather_Widget
 *
 * Handles the WordPress Widget.
 *
 * @since 0.1.0
 */
class WWI_Weather_Widget extends WP_Widget {


	/**
	 * WWI_Weather_Widget constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {

		$widget_ops = array(
			'classname'   => 'wwi_weather_widget',
			'description' => __( 'Displays the current temperature.', 'wi-weather' ),
		);

		parent::__construct( 'wwi_weather_widget', __( 'WI Weather', 'wi-weather' ), $widget_ops );
	}


	/**
	 * Displays the Widget on the frontend.
	 *
	 * @since 0.1.0
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$place = apply_filters( 'wi_weather_widget_place', empty( $instance['place'] ) ? '' : $instance['place'], $instance, $this->id_base );

		echo $args['before_widget'];

		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		?>
		<div class="wi-weather-temp">
			<?php

			$temp = floatval( get_option( 'wi-weather', 0.0 ) );

			printf(
				__( '%d °C', 'wi-weather' ),
				number_format_i18n( $temp, 1 )
			);
			?>
		</div>

		<p class="wi-weather-desc">
			<?php
			printf(
				__( 'Current Temperature in %s', 'wi-weather' ),
				implode( ' » ', explode( '/', $place ) )
			);
			?>
		</p>

		<p class="wi-weather-copyright">
			<?php _e( 'Weather forecast from Yr, delivered by the Norwegian Meteorological Institute and NRK.', 'wi-weather' ); ?>
		</p>

		<?php
		echo $args['after_widget'];
	}

	/**
	 * Updates the Widget form from the backend.
	 *
	 * @since 0.1.0
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance          = $old_instance;
		$instance['title'] = sanitize_text_field( strip_tags( $new_instance['title'] ) );
		$instance['place'] = sanitize_text_field( strip_tags( $new_instance['place'] ) );

		return $instance;
	}


	/**
	 * Displays the widget form on the backend.
	 *
	 * @since 0.1.0
	 *
	 * @param array $instance
	 *
	 * @return string|void
	 */
	public function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'place' => '' ) );

		$field = '<p><label for="%s">%s</label><input class="widefat" id="%s" name="%s" type="text" value="%s"/></p>';

		# The title field
		printf(
			$field,
			esc_attr( $this->get_field_id( 'title' ) ),
			__( 'Title:', 'wi-weather' ),
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( strip_tags( $instance['title'] ) )
		);

		# The ZIP field
		printf(
			$field,
			esc_attr( $this->get_field_id( 'place' ) ),
			__( 'Place:', 'wi-weather' ),
			esc_attr( $this->get_field_id( 'place' ) ),
			esc_attr( $this->get_field_name( 'place' ) ),
			esc_attr( strip_tags( $instance['place'] ) )
		);

		printf(
			'<p class="description">%s</p>',
			__( 'Go to <a href="https://www.yr.no/" target="_blank">yr.no</a> to find the right place.', 'wi-weather' )
		);
	}

}
