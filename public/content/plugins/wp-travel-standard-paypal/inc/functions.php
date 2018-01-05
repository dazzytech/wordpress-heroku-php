<?php
/**
 * Functions.
 *
 * @package wp-travel-paypal/inc/
 */

/**
 * Register Post type for Payment.
 *
 * @return void
 */
function wp_travel_paypal_register_post_type() {
	$labels = array(
		'name'               => _x( 'Payments', 'post type general name', 'wp-travel' ),
		'singular_name'      => _x( 'Payment', 'post type singular name', 'wp-travel' ),
		'menu_name'          => _x( 'Payments', 'admin menu', 'wp-travel' ),
		'name_admin_bar'     => _x( 'Payment', 'add new on admin bar', 'wp-travel' ),
		'add_new'            => _x( 'Add New', 'wp-travel', 'wp-travel' ),
		'add_new_item'       => __( 'Add New Payment', 'wp-travel' ),
		'new_item'           => __( 'New Payment', 'wp-travel' ),
		'edit_item'          => __( 'Edit Payment', 'wp-travel' ),
		'view_item'          => __( 'View Payment', 'wp-travel' ),
		'all_items'          => __( 'All Payments', 'wp-travel' ),
		'search_items'       => __( 'Search Payments', 'wp-travel' ),
		'parent_item_colon'  => __( 'Parent Payments:', 'wp-travel' ),
		'not_found'          => __( 'No Payments found.', 'wp-travel' ),
		'not_found_in_trash' => __( 'No Payments found in Trash.', 'wp-travel' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'wp-travel' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => false,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'itinerary-payment' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'comments' ),
		'menu_icon'          => 'dashicons-cart',
	);
	/**
	 * Register a Payments post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	register_post_type( 'wp-travel-payment', $args );
}

/**
 * List of payment fields
 *
 * @return array
 */
function wp_travel_get_payment_field_list() {
	return array(
		'is_partial_payment',
		'payment_gateway',
		'booking_option',
		'trip_price',

		'payment_mode',
		'payment_amount',
		'trip_price_info',
		'payment_amount_info',
	);
}

/**
 * Add Payment fields in booking form.
 *
 * @param Array $fields Booking fields.
 * @return Array
 */
function wtp_booking_fields( $fields ) {
	if ( ! $fields ) {
		return;
	}

	if ( ! wp_travel_is_enable_payment() ) {
		return $fields;
	}

	$post_id = 0;
	global $post;
	if ( isset( $post->ID ) ) {
		$post_id = $post->ID;
	}
	if ( isset( $_POST['wp_travel_post_id'] ) ) {
		$post_id = $_POST['wp_travel_post_id'];
	}
	$minimum_partial_payout = wp_travel_get_minimum_partial_payout( $post_id );
	$actual_trip_price = wp_travel_get_actual_trip_price( $post_id );
	$per_person_text = wp_travel_get_price_per_text( $post_id );
	$settings = wp_travel_get_settings();

	$partial_payment = isset( $settings['partial_payment'] ) ? $settings['partial_payment'] : '';

	$payment_fields = array();
	$payment_fields['is_partial_payment'] = array(
		'type' => 'hidden',
		'name' => 'wp_travel_is_partial_payment',
		'id' => 'wp-travel-partial-payment',
		'default' => $partial_payment,
		'priority' => 98,
	);
	$payment_fields['payment_gateway'] = array(
		'type' => 'hidden',
		'name' => 'wp_travel_payment_gateway',
		'id' => 'wp-travel-payment-gateway',
		'default' => 'paypal',
		'priority' => 99,
	);
	$payment_fields['booking_option'] = array(
		'type' => 'radio',
		'label' => __( 'Booking Options', 'wp-travel' ),
		'name' => 'wp_travel_booking_option',
		'id' => 'wp-travel-option',
		'validations' => array(
			'required' => true,
		),
		'options' => array( 'booking_with_payment' => esc_html__( 'Booking with payment' ), 'booking_only' => esc_html__( 'Booking only' ) ),
		'default' => 'booking_with_payment',
		'priority' => 100,
	);
	$payment_fields['trip_price'] = array(
		'type' => 'number',
		'label' => __( 'Trip Price', 'wp-travel' ),
		'name' => 'wp_travel_trip_price',
		'id' => 'wp-travel-trip-price',
		'validations' => array(
			'required' => true,
		),
		'before_field' => wp_travel_get_currency_symbol(),
		'before_field_class' => 'wp-travel-currency-symbol',
		'default' => number_format( $actual_trip_price, 2, '.', '' ),
		'attributes' => array( 'step' => 0.01, 'price_per' => $per_person_text, 'trip_price' => $actual_trip_price ),
		'priority' => 102,
	);
	$payment_amount = $actual_trip_price;
	if ( isset( $settings['partial_payment'] ) && 'yes' === $settings['partial_payment'] ) {
		$payment_amount = $minimum_partial_payout;
		$payment_fields['payment_mode'] = array(
			'type' => 'radio',
			'label' => __( 'Payment Mode', 'wp-travel' ),
			'name' => 'wp_travel_payment_mode',
			'id' => 'wp-travel-payment-mode',
			'validations' => array(
				'required' => true,
			),
			'options' => array( 'partial' => esc_html__( 'Partial Payment' ), 'full' => esc_html__( 'Full Payment' ) ),
			'default' => 'full',
			'priority' => 101,
		);
	}
	$payment_fields['payment_amount'] = array(
		'type' => 'number',
		'label' => __( 'Payment Amount', 'wp-travel' ),
		'name' => 'wp_travel_payment_amount',
		'id' => 'wp-travel-payment-amount',
		'validations' => array(
			'required' => true,
		),
		'attributes' => array(
			'step' => 0.01,
		),
		'before_field_class' => 'wp-travel-currency-symbol',
		'before_field' => wp_travel_get_currency_symbol(),
		'default' => number_format( $payment_amount, 2, '.', '' ),
		'priority' => 105,
	);
	if ( $actual_trip_price > 0 ) {
		$payment_fields['payment_amount']['attributes']['min'] = $minimum_partial_payout;
		$payment_fields['payment_amount']['attributes']['max'] = $actual_trip_price;
	} 

	$payment_fields['trip_price_info'] = array(
		'type' => 'text_info',
		'label' => __( 'Trip Price', 'wp-travel' ),
		'name' => 'wp_travel_trip_price_info',
		'id' => 'wp-travel-trip-price_info',
		'before_field' => wp_travel_get_currency_symbol(),
		'default' => number_format( $actual_trip_price, 2, '.', '' ),
		'wrapper_class' => 'full-width hide-in-admin',
		'priority' => 110,
	);
	$payment_fields['payment_amount_info'] = array(
		'type' => 'text_info',
		'label' => __( 'Payment Amount', 'wp-travel' ),
		'name' => 'wp_travel_payment_amount_info',
		'id' => 'wp-travel-payment-amount-info',
		'validations' => array(
			'required' => true,
		),
		'attributes' => array(
			'min' => $minimum_partial_payout,
			'max' => $actual_trip_price,
		),
		'before_field' => wp_travel_get_currency_symbol(),
		'default' => number_format( $payment_amount, 2, '.', '' ),
		'wrapper_class' => 'full-width hide-in-admin',
		'priority' => 115,
	);
	$payment_field_list = wp_travel_get_payment_field_list();
	foreach ( $payment_field_list as $field_list ) {
		if ( isset( $payment_fields[ $field_list ] ) && is_array( $payment_fields[ $field_list ] ) ) {
			if ( 'payment_mode' === $field_list ) {
				if ( isset( $settings['partial_payment'] ) && 'yes' === $settings['partial_payment'] ) {
					$fields[ $field_list ] = $payment_fields[ $field_list ];
				}
				continue;
			}
			$fields[ $field_list ] = $payment_fields[ $field_list ];
		}
	}

	return $fields;
}

/**
 * Send Booking and payment email to admin & customer.
 *
 * @param Number $booking_id Booking ID.
 * @return void
 */
function wp_travel_send_payment_email( $booking_id ) {
	if ( ! $booking_id ) {
		return;
	}

	$settings = wp_travel_get_settings();

	$send_booking_email_to_admin = ( isset( $settings['send_booking_email_to_admin'] ) && '' !== $settings['send_booking_email_to_admin'] ) ? $settings['send_booking_email_to_admin'] : 'yes';

	// Prepare variables to assign in email.
	$client_email = get_post_meta( $booking_id, 'wp_travel_email', true );

	$admin_email = get_option( 'admin_email' );

	// Email Variables.
	if ( is_multisite() ) {
		$sitename = get_network()->site_name;
	} else {
		/*
			* The blogname option is escaped with esc_html on the way into the database
			* in sanitize_option we want to reverse this for the plain text arena of emails.
			*/
		$sitename = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
	}

	$itinerary_id 			= get_post_meta( $booking_id, 'wp_travel_post_id', true );
	$payment_id = get_post_meta( $booking_id, 'wp_travel_payment_id', true );

	$trip_code = wp_travel_get_trip_code( $itinerary_id );
	$title = 'Booking - ' . $trip_code;

	$itinerary_title 		= get_the_title( $itinerary_id );

	$booking_no_of_pax 		= get_post_meta( $booking_id, 'wp_travel_pax', true );
	$booking_scheduled_date = 'N/A';
	$booking_arrival_date 	= get_post_meta( $booking_id, 'wp_travel_arrival_date', true );
	$booking_departure_date = get_post_meta( $booking_id, 'wp_travel_departure_date', true );

	$customer_name 		  	= get_post_meta( $booking_id, 'wp_travel_fname', true ) . ' ' . get_post_meta( $booking_id, 'wp_travel_lname', true );
	$customer_country 		= get_post_meta( $booking_id, 'wp_travel_country', true );
	$customer_address 		= get_post_meta( $booking_id, 'wp_travel_address', true );
	$customer_phone 		= get_post_meta( $booking_id, 'wp_travel_phone', true );
	$customer_email 		= get_post_meta( $booking_id, 'wp_travel_email', true );
	$customer_note 			= get_post_meta( $booking_id, 'wp_travel_note', true );

	$wp_travel_payment_status = get_post_meta( $payment_id, 'wp_travel_payment_status', true );
	$wp_travel_payment_mode   = get_post_meta( $payment_id, 'wp_travel_payment_mode', true );
	$trip_price = get_post_meta( $payment_id, 'wp_travel_trip_price', true );
	$payment_amount    = get_post_meta( $payment_id, 'wp_travel_payment_amount', true );

	$email_tags = array(
		'{sitename}'				=> $sitename,
		'{itinerary_link}'			=> get_permalink( $itinerary_id ),
		'{itinerary_title}'			=> $itinerary_title,
		'{booking_id}'				=> $booking_id,
		'{booking_edit_link}'		=> get_edit_post_link( $booking_id ),
		'{booking_no_of_pax}'		=> $booking_no_of_pax,
		'{booking_scheduled_date}'	=> $booking_scheduled_date,
		'{booking_arrival_date}'	=> $booking_arrival_date,
		'{booking_departure_date}'	=> $booking_departure_date,

		'{customer_name}'			=> $customer_name,
		'{customer_country}'		=> $customer_country,
		'{customer_address}'		=> $customer_address,
		'{customer_phone}'			=> $customer_phone,
		'{customer_email}'			=> $customer_email,
		'{customer_note}'			=> $customer_note,
		'{payment_status}'			=> $wp_travel_payment_status,
		'{payment_mode}'			=> $wp_travel_payment_mode,
		'{trip_price}'				=> $trip_price,
		'{payment_amount}'			=> $payment_amount,
		'{currency_symbol}'			=> wp_travel_get_currency_symbol(),
	);

	$admin_message = wp_travel_admin_email_template();
	$admin_message = str_replace( array_keys( $email_tags ), $email_tags, $admin_message );

	$admin_payment_message = wp_travel_payment_admin_email_template();
	$admin_payment_message = str_replace( array_keys( $email_tags ), $email_tags, $admin_payment_message );

	// Client message.
	$message = wp_travel_customer_email_template();
	$message = str_replace( array_keys( $email_tags ), $email_tags, $message );

	$payment_message = wp_travel_payment_customer_email_template();
	$payment_message = str_replace( array_keys( $email_tags ), $email_tags, $payment_message );

	// Send mail to admin if booking email is set to yes.
	if ( 'yes' == $send_booking_email_to_admin ) {
		// To send HTML mail, the Content-type header must be set.
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Create email headers.
		$headers .= 'From: ' . $client_email . "\r\n" .
		'Reply-To: ' . $client_email . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

		if ( ! wp_mail( $admin_email, wp_specialchars_decode( $title ), $admin_message, $headers ) ) {
			wp_send_json( array(
				'result'  => 0,
				'message' => __( 'Your Itinerary Has Been added but the email could not be sent.', 'wp-travel' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.', 'wp-travel' ),
			) );
		}

		if ( ! wp_mail( $admin_email, wp_specialchars_decode( $title . ' - Payment' ), $admin_payment_message, $headers ) ) {
			wp_send_json( array(
				'result'  => 0,
				'message' => __( 'Your Itinerary Has Been added but the email could not be sent.', 'wp-travel' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.', 'wp-travel' ),
			) );
		}
	}

	// Send email to client.
	// To send HTML mail, the Content-type header must be set.
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	// Create email headers.
	$headers .= 'From: ' . $admin_email . "\r\n" .
	'Reply-To: ' . $admin_email . "\r\n" .
	'X-Mailer: PHP/' . phpversion();

	if ( ! wp_mail( $client_email, wp_specialchars_decode( $title ), $message, $headers ) ) {

		wp_send_json( array(
			'result'  => 0,
			'message' => __( 'Your Itinerary Has Been added but the email could not be sent.', 'wp-travel' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.', 'wp-travel' ),
		) );
	}
	if ( ! wp_mail( $client_email, wp_specialchars_decode( $title . ' - Payment' ), $payment_message, $headers ) ) {
		wp_send_json( array(
			'result'  => 0,
			'message' => __( 'Your Itinerary Has Been added but the email could not be sent.', 'wp-travel' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.', 'wp-travel' ),
		) );
	}
}

/**
 * Return booking message.
 *
 * @param String $message Booking message
 * @return void
 */
function wp_travel_paypal_booking_message( $message ) {
	if ( ! isset( $_GET['booking_id'] ) ) {
		return $message;
	}
	$booking_id = $_GET['booking_id'];
	if ( isset( $_GET['status'] ) && 'cancel' === $_GET['status'] ) {
		update_post_meta( $booking_id, 'wp_travel_payment_status', 'canceled' );
		$message = esc_html__( 'Your booking has been canceled', 'wp-travel' );
	}
	if ( isset( $_GET['status'] ) && 'success' === $_GET['status'] ) {
		// already upadted status.
		$message = esc_html__( "We've received your booking and payment details. We'll contact you soon.", 'wp-travel' );
	}
	return $message;
}

/**
 * Filter input field values of payment fields
 *
 * @param String $input_val  Value of field.
 * @param Number $post_id    Post ID.
 * @param String $field_key  Field key to verify payment fields.
 * @param String $field_name Name of inpug field.
 * @return String
 */
function wp_travel_payment_field_values( $input_val, $post_id, $field_key, $field_name ) {

	$payment_field_list = wp_travel_get_payment_field_list();

	if ( in_array( $field_key, $payment_field_list ) ) {
		$payment_id = get_post_meta( $post_id, 'wp_travel_payment_id', true );
		$input_val = get_post_meta( $payment_id, $field_name, true );
	}
	return $input_val;
}

add_filter( 'wp_travel_booking_field_value', 'wp_travel_payment_field_values', 10, 4 );

function wp_travel_payment_post_id_to_update( $post_id, $field_key, $field_name  ) {
	$payment_field_list = wp_travel_get_payment_field_list();
	$payment_id = $post_id;
	if ( in_array( $field_key, $payment_field_list ) ) {
		$payment_id = get_post_meta( $post_id, 'wp_travel_payment_id', true );
		// $input_val = get_post_meta( $payment_id, $field_name, true );
	}
	return $payment_id;
}
add_filter( 'wp_travel_booking_post_id_to_update', 'wp_travel_payment_post_id_to_update', 10, 3 );


function wp_travel_update_payment_status_booking_process( $booking_id ) {
	if ( ! $booking_id ) {
		return;
	}
	$payment_id = get_post_meta( $booking_id, 'wp_travel_payment_id', true );
	if ( ! $payment_id ) {
		$title = 'Payment - #' . $booking_id;
		$post_array = array(
			'post_title' => $title,
			'post_content' => '',
			'post_status' => 'publish',
			'post_slug' => uniqid(),
			'post_type' => 'wp-travel-payment',
			);
		$payment_id = wp_insert_post( $post_array );
		update_post_meta( $booking_id, 'wp_travel_payment_id', $payment_id );
	}
	$booking_field_list = wp_travel_booking_form_fields();
	$payment_field_list = wp_travel_get_payment_field_list();

	foreach ( $payment_field_list as $field_list ) {
		$meta_field = $booking_field_list[ $field_list ]['name'];
		if ( isset( $_POST[ $meta_field ] ) ) {
			$meta_value = $_POST[ $meta_field ];
			update_post_meta( $payment_id, $meta_field, $meta_value );
		}
	}
	update_post_meta( $payment_id, 'wp_travel_payment_status', 'N/A' );
}
add_action( 'wt_before_payment_process', 'wp_travel_update_payment_status_booking_process' );
