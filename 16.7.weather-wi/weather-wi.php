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
		'weather-wi',
		plugin_dir_url( __FILE__ ) . 'assets/css/frontend.css',
		array(),
		filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/frontend.css' )
	);

	wp_enqueue_style( 'weather-wi' );
}


/**
 * Fetches a temperature from a place.
 *
 * @since 0.1.0
 *
 * @param string $place
 *
 * @return array|\WP_Error
 */
function wwi_fetch_weather( $place ) {

	if ( ! function_exists( 'simplexml_load_string' ) ) {
		return new WP_Error(
			'wwi_fetch_temp',
			__( 'This widget-plugin needs the SimpleXML extension from PHP.', 'weather-wi' )
		);
	}

	# remove trailing slash
	$place = untrailingslashit( $place );

	# remove leading slash (if any)
	if ( 0 === stripos( $place, '/' ) ) {
		$place = substr( $place, 1 );
	}

	# build URL
	$url = sprintf( '%s%s%s', 'https://www.yr.no/sted/', $place, '/varsel.xml' );
	$url = esc_url_raw( $url );

	# make request
	$response = wp_remote_get( $url );

	# check for errors
	if ( is_wp_error( $response ) ) {
		return $response;
	}

	# fetch response code
	$response_code = wp_remote_retrieve_response_code( $response );

	# check if response code is 2xx
	if ( 2 != substr( $response_code, 0, 1 ) ) {
		return new WP_Error(
			'wwi_fetch_temp',
			sprintf(
				__( 'Could not fetch temperature. Response code was: %s', 'weather-wi' ),
				wp_remote_retrieve_response_code( $response )
			)
		);
	}

	# get the actual body
	$response_body = wp_remote_retrieve_body( $response );

	# transform to SimpleXMLElement
	$xml = simplexml_load_string( $response_body );

	# check for errors
	if ( false === $xml ) {
		return new WP_Error(
			'wwi_fetch_temp',
			__( 'Could not fetch XML data.', 'weather-wi' )
		);
	}

	# check if there is weather data
	if ( ! isset( $xml->forecast ) || ! isset( $xml->forecast->tabular ) ) {
		return new WP_Error(
			'wwi_fetch_temp',
			__( 'No forecast data found.', 'weather-wi' )
		);
	}

	$ret = array();

	# build the array of weather data
	foreach ( $xml->forecast->tabular->children() as $weather_data ) {
		$temperature = $weather_data->temperature->attributes();
		$time        = strtotime( $weather_data->attributes()->from->__toString() );

		$ret[] = array(
			'temperature'      => floatval( $temperature->value->__toString() ),
			'temperature_unit' => sanitize_text_field( $temperature->unit->__toString() ),
			'time'             => $time,
			'symbol'           => $weather_data->symbol->attributes()->var->__toString(),
		);
	}

	return $ret;
}


/**
 * Filter old weather data.
 *
 * @since 0.1.0
 *
 * @param array $weather_data
 *
 * @return array
 */
function wwi_filter_old_weather_data( $weather_data ) {

	return array_filter( $weather_data, function ( $data ) {

		return $data['time'] >= time();
	} );
}

register_activation_hook( __FILE__, 'wwi_plugin_activation' );

/**
 * Activation function.
 *
 * @since 0.1.0
 */
function wwi_plugin_activation() {

	if ( ! wp_next_scheduled( 'wwi_update_weather' ) ) {
		wp_schedule_event( time(), 'every2hours', 'wwi_update_weather' );
	}
}

register_deactivation_hook( __FILE__, 'wwi_plugin_deactivation' );

/**
 * Deactivation function.
 *
 * @since 0.1.0
 */
function wwi_plugin_deactivation() {

	wp_clear_scheduled_hook( 'wwi_update_weather' );
}


add_action( 'wwi_update_weather', 'wwi_cron_update_weather' );

/**
 * Updates weather-data via Cron.
 *
 * @since 0.1.0
 */
function wwi_cron_update_weather() {

	# get all settings from weather widget instances
	$widgets_settings = get_option( 'widget_wwi_weather_widget' );

	# stop if it's not an array
	if ( ! is_array( $widgets_settings ) ) {
		return;
	}

	# stop if there is no widget in a sidebar
	if ( count( $widgets_settings ) <= 0 ) {
		return;
	}

	foreach ( $widgets_settings as $instance => $widget_setting ) {
		if ( ! isset( $widget_setting['place'] ) ) {
			continue;
		}

		if ( empty( $widget_setting['place'] ) ) {
			continue;
		}

		$weather_data = wwi_fetch_weather( $widget_setting['place'] );

		if ( is_wp_error( $weather_data ) ) {
			continue;
		}

		update_option( 'wwi_weather_widget-' . $instance, $weather_data, 'yes' );
	}

}

add_filter( 'cron_schedules', 'wwi_cron_schedules' );

/**
 * Add own cron schedule times.
 *
 * @since 0.1.0
 *
 * @param array $schedules
 *
 * @return array
 */
function wwi_cron_schedules( $schedules ) {

	if ( isset( $schedules['every2hours'] ) ) {
		return $schedules;
	}

	$schedules['every2hours'] = array(
		'interval' => 2 * HOUR_IN_SECONDS,
		'display'  => __( 'Every 2 hours', 'weather-wi' ),
	);

	return $schedules;
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
			'description' => __( 'Displays the current temperature.', 'weather-wi' ),
		);

		parent::__construct( 'wwi_weather_widget', __( 'WI Weather', 'weather-wi' ), $widget_ops );
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

		# print header
		echo $args['before_widget'];

		# print title
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		# fetch weather data
		$weather_data = get_option( $this->id, null );

		# fetch live data if option returns NULL
		if ( is_null( $weather_data ) ) {
			$weather_data = wwi_fetch_weather( $place );
		}

		# print error if any
		if ( is_wp_error( $weather_data ) ) {
			printf( '<p class="wi-weather-error">%s</p>', $weather_data->get_error_message() );
		} else {

			# filter old weather data
			$weather_data = wwi_filter_old_weather_data( $weather_data );

			# print error if there is no weather data left
			if ( count( $weather_data ) <= 0 ) {
				printf( '<p class="wi-weather-error">%s</p>', __( 'No fresh weather data found.', 'weather-wi' ) );
			} else {

				# fetch the first weather value available
				$weather_data = array_values( $weather_data )[0];

				# fetch date and time format (as set in WordPress settings)
				$date_format = get_option( 'date_format', 'j. F Y' );
				$time_format = get_option( 'time_format', 'G:i' );

				# print the weather image
				printf(
					'<img src="http://symbol.yr.no/grafikk/sym/b38/%s.png" />',
					esc_attr( $weather_data['symbol'] )
				);

				# build the temperature string
				$temp = sprintf(
					__( '%d %s', 'weather-wi' ),
					number_format_i18n( $weather_data['temperature'], 1 ),
					'celsius' === $weather_data['temperature_unit'] ? '°C' : 'K'
				);

				# output the temperature string
				printf(
					'<div class="wi-weather-temp">%s</div><div class="wi-weather-date">%s</div>',
					$temp,
					date_i18n( $date_format . ' ' . $time_format, $weather_data['time'] )
				);

			}
		}

		# output the place
		?>
		<p class="wi-weather-desc">
			<?php
			printf(
				__( 'Current Temperature in %s', 'weather-wi' ),
				implode( ' » ', explode( '/', $place ) )
			);
			?>
		</p>

		<!-- The weather copyright -->
		<p class="wi-weather-copyright">
			<?php _e( 'Weather forecast from Yr, delivered by the Norwegian Meteorological Institute and NRK.', 'weather-wi' ); ?>
		</p>

		<?php
		# print footer
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
			__( 'Title:', 'weather-wi' ),
			esc_attr( $this->get_field_id( 'title' ) ),
			esc_attr( $this->get_field_name( 'title' ) ),
			esc_attr( strip_tags( $instance['title'] ) )
		);

		# The ZIP field
		printf(
			$field,
			esc_attr( $this->get_field_id( 'place' ) ),
			__( 'Place:', 'weather-wi' ),
			esc_attr( $this->get_field_id( 'place' ) ),
			esc_attr( $this->get_field_name( 'place' ) ),
			esc_attr( strip_tags( $instance['place'] ) )
		);

		printf(
			'<p class="description">%s</p>',
			__( 'Go to <a href="https://www.yr.no/" target="_blank">yr.no</a> to find the right place.', 'weather-wi' )
		);
	}

}
