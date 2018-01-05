<?php
/**
 * Update payment meta.
 *
 * @package wp-travel-paypal/inc/
 */

 /**
 * Update Payment Post type and meta.
 */
function update_payment_post_type() {
	global $wpdb;

	$query = "Select ID from {$wpdb->posts} where post_status='publish' and post_type='itinerary-booking'";

	$result = $wpdb->get_results( $query );

	if ( count( $result ) > 0 ) {
		foreach ( $result as $booking ) {
			$booking_id = $booking->ID;

			$payment_id = get_post_meta( $booking_id, 'wp_travel_payment_id', true );
			// error_log( 'booking_id = ' . $booking_id . ' - payment_id = ' . $payment_id . "\n" );
			if ( ! $payment_id ) {
				// Retrive old payment info.
				$booking_option = get_post_meta( $booking_id, 'wp_travel_booking_option', true );

				if ( $booking_option === 'booking_with_payment' ) {
					$title = 'Payment - #' . $booking_id;
					$post_array = array(
						'post_title' => $title,
						'post_content' => '',
						'post_status' => 'publish',
						'post_slug' => uniqid(),
						'post_type' => 'wp-travel-payment',
						'post_date' => get_the_time('Y-m-d H:i:s', $booking_id ),
						);
					$payment_id = wp_insert_post( $post_array );

					$payment_fields = wp_travel_get_payment_field_list();
					//  array(
					// 	'wp_travel_payment_status',
					// 	'wp_travel_trip_price',
					// 	'wp_travel_payment_amount',
					// 	'wp_travel_payment_mode',
					// 	'wp_travel_booking_option',
					// 	'wp_travel_booking_option',
					// );
					foreach ( $payment_fields as $payment_field ) {
						$meta_val = get_post_meta( $booking_id, $payment_field, true );
						update_post_meta( $payment_id, $payment_field, $meta_val );
					}
					update_post_meta( $booking_id, 'wp_travel_payment_id', $payment_id );
				}
			}
		}
	}
}
update_payment_post_type();