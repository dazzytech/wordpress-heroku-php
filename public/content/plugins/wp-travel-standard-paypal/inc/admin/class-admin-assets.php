<?php
/**
 * Admin Enqueue.
 *
 * @package wp-travel-paypal/inc/admin/
 */

/**
 * Class Admin assets.
 */
class WP_Travel_Paypal_Admin_Assets {
	var $assets_path;
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->assets_path = plugin_dir_url( WP_TRAVEL_PAYPAL_PLUGIN_FILE );
		add_action( 'admin_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Admin CSS.
	 *
	 * @return void
	 */
	function styles() {
		wp_enqueue_style( 'wp-travel-payment-admin-common', $this->assets_path . 'assets/css/admin-common.css' );
		wp_enqueue_style( 'jquery-ui-slider-css', $this->assets_path . 'assets/css/admin-slider.css' );
	}
	/**
	 * Admin Scripts.
	 *
	 * @return void
	 */
	function scripts() {
		$screen = get_current_screen();
		if ( is_object( $screen ) && 'itineraries_page_settings' === $screen->id ) {
			$settings = get_option( 'wp_travel_settings' );
			$minimum_partial_payout = isset( $settings['minimum_partial_payout'] ) ? $settings['minimum_partial_payout'] : WP_TRAVEL_MINIMUM_PARTIAL_PAYOUT;

			$wtp_admin_data = array(
				'minimum_partial_payout' => $minimum_partial_payout,
			);
			wp_register_script( 'wp-travel-payment-admin-slider', $this->assets_path . 'assets/js/admin-range-slider.js', array( 'jquery', 'jquery-ui-slider' ) );
			wp_localize_script( 'wp-travel-payment-admin-slider', 'wtp_admin_data', $wtp_admin_data );
			wp_enqueue_script( 'wp-travel-payment-admin-slider' );
		}

		if ( is_object( $screen ) && 'itinerary-booking' === $screen->id ) {
			wp_enqueue_script( 'wp-travel-payment-admin-booking', $this->assets_path . 'assets/js/admin-booking.js', array( 'jquery' ) );
		}
		if ( is_object( $screen ) && 'itineraries_page_booking_chart' === $screen->id ) {
			wp_enqueue_script( 'wp-travel-payment-admin-stat', $this->assets_path . 'assets/js/admin-stat.js', array( 'jquery' ) );
		}
	}

}

new WP_Travel_Paypal_Admin_Assets();
