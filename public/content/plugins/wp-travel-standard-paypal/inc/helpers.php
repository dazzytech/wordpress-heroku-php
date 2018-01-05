<?php
/**
 * Helper for wp-travel-paypal.
 *
 * @package wp-travel-paypal/inc/
 */

/**
 * What type of request is this?
 *
 * @param  string $type admin, ajax, cron or frontend.
 * @return bool
 */
function wtp_is_request( $type ) {
	switch ( $type ) {
		case 'admin' :
			return is_admin();
		case 'ajax' :
			return defined( 'DOING_AJAX' );
		case 'cron' :
			return defined( 'DOING_CRON' );
		case 'frontend' :
			return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
	}
}
/**
 * Get Minimum payout amount
 *
 * @param Number $post_id Post ID.
 * @return Number
 */
function wp_travel_get_minimum_partial_payout( $post_id ) {
	if ( ! $post_id ) {
		return 0;
	}
	$minimum_payout = get_post_meta( $post_id, 'wp_travel_minimum_partial_payout', true );

	if ( ! $minimum_payout ) {

		$settings = wp_travel_get_settings();
		$payout_percent = ( isset( $settings['minimum_partial_payout'] ) && $settings['minimum_partial_payout'] > 0 )? $settings['minimum_partial_payout']  : WP_TRAVEL_MINIMUM_PARTIAL_PAYOUT;

		$trip_price = wp_travel_get_actual_trip_price( $post_id );
		$minimum_payout = ( $trip_price * $payout_percent ) / 100;
	}
	return number_format( $minimum_payout, 2, '.', '' );
}

/** Return true if test mode checked */
function wp_travel_payment_test_mode() {
	$settings = wp_travel_get_settings();
	// Default true.
	if ( ! isset( $settings['wt_test_mode'] ) ) {
		return true;
	}
	if ( isset( $settings['wt_test_mode'] ) && 'yes' === $settings['wt_test_mode'] ) {
		return true;
	}
	return false;
}

/** Return true if Payment checked */
function wp_travel_is_enable_payment() {
	$settings = wp_travel_get_settings();

	if ( isset( $settings['payment_option_paypal'] ) && 'yes' === $settings['payment_option_paypal'] ) {
		return true;
	}
	return false;
}
