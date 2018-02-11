<?php
/**
 * Functions.
 *
 * @package wp-travel-paypal/inc/admin/
 */

/**
 * Add Tabs to settings page.
 *
 * @param array $tabs Tabs array list.
 */
function wp_travel_payment_add_tabs( $tabs ) {
	$fields_payment = array(
		'tab_label' => __( 'Payment', 'wp-travel' ),
		'content_title' => __( 'Payment Settings', 'wp-travel' ),
	);

	$tabs['settings']['payment'] = $fields_payment;
	if ( ! isset( $tabs['settings']['debug'] ) ) {
		$fields_debug = array(
			'tab_label' => __( 'Debug', 'wp-travel' ),
			'content_title' => __( 'Debug Options', 'wp-travel' ),
		);
		$tabs['settings']['debug'] = $fields_debug;
	}
	return $tabs;
}

/**
 * Callback for Payment tab.
 *
 * @param  Array $tab  List of tabs.
 * @param  Array $args Settings arg list.
 */
function wp_travel_payment_tab_call_back( $tab, $args ) {
	if ( 'payment' !== $tab ) {
		return;
	}
	$partial_payment = isset( $args['settings']['partial_payment'] ) ? $args['settings']['partial_payment'] : '';
	$minimum_partial_payout = isset( $args['settings']['minimum_partial_payout'] ) ? $args['settings']['minimum_partial_payout'] : WP_TRAVEL_MINIMUM_PARTIAL_PAYOUT;
	$paypal_email = ( isset( $args['settings']['paypal_email'] ) ) ? $args['settings']['paypal_email'] : '';
	$payment_option_paypal = ( isset( $args['settings']['payment_option_paypal'] ) ) ? $args['settings']['payment_option_paypal'] : ''; ?>
	
	<table class="form-table">
		<tr>
			<th><label for="partial_payment"><?php esc_html_e( 'Partial Payment', 'wp-travel' ) ?></label></th>
			<td>
				<label><input type="checkbox" value="yes" <?php checked( 'yes', $partial_payment ) ?> name="partial_payment" id="partial_payment"/><?php esc_html_e( 'Enable' ) ?></label>
				<p class="description"><?php esc_html_e( 'Enable partial payment while booking.', 'wp-travel' ) ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="minimum_partial_payout"><?php esc_html_e( 'Minimum Payout (%)', 'wp-travel' ) ?></label></th>
			<td>
				<input type="range" min="1" max="100" step="0.01" value="<?php echo esc_attr( $minimum_partial_payout ) ?>" name="minimum_partial_payout" id="minimum_partial_payout" class="wt-slider" />
				<label><input type="number" step="0.01" value="<?php echo esc_attr( $minimum_partial_payout ) ?>" name="minimum_partial_payout" id="minimum_partial_payout_output" />%</label>
				<p class="description"><?php esc_html_e( 'Minimum percent of amount to pay while booking.', 'wp-travel' ) ?></p>
			</td>
		</tr>
	</table>
	<?php do_action( 'wp_travel_payment_gateway_fields' ); ?>
	<h3 class="wp-travel-tab-content-title"><?php esc_html_e( 'Standard Paypal', 'wp-travel' )?></h3>
	<table class="form-table">
		<tr>
			<th><label for="payment_option_paypal"><?php esc_html_e( 'Enable Paypal', 'wp-travel' ) ?></label></th>
			<td>
				<label><input type="checkbox" value="yes" <?php checked( 'yes', $payment_option_paypal ) ?> name="payment_option_paypal" id="payment_option_paypal"/><?php esc_html_e( 'Enable' ) ?></label>
				<p class="description"><?php esc_html_e( 'Check to enable standard PayPal payment.', 'wp-travel' ) ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="paypal_email"><?php esc_html_e( 'Paypal Email', 'wp-travel' ) ?></label></th>
			<td>
				<input type="text" value="<?php echo esc_attr( $paypal_email ) ?>" name="paypal_email" id="paypal_email"/>
				<p class="description"><?php esc_html_e( 'PayPal email address that receive payment.', 'wp-travel' ) ?></p>
			</td>
		</tr>
	</table>
<?php
}

/**
 * Callback for Debug tab.
 *
 * @param  Array $tab  List of tabs.
 * @param  Array $args Settings arg list.
 */
function wp_travel_debug_tab_call_back( $tab, $args ) {
	if ( 'debug' !== $tab ) {
		return;
	}
	$wt_test_mode = ( isset( $args['settings']['wt_test_mode'] ) ) ? $args['settings']['wt_test_mode'] : 'yes';
	$wt_test_email = ( isset( $args['settings']['wt_test_email'] ) ) ? $args['settings']['wt_test_email'] : '';
	?>
	<h4 class="wp-travel-tab-content-title"><?php esc_html_e( 'Test Payment', 'wp-travel' ) ?></h4>
	<table class="form-table">
		<tr>
			<th><label for="wt_test_mode"><?php esc_html_e( 'Test Mode', 'wp-travel' ) ?></label></th>
			<td>
				<label><input type="checkbox" value="yes" <?php checked( 'yes', $wt_test_mode ) ?> name="wt_test_mode" id="wt_test_mode"/><?php esc_html_e( 'Enable' ) ?></label>
				<p class="description"><?php esc_html_e( 'Enable test mode to make test payment.', 'wp-travel' ) ?></p>
			</td>
		</tr>
		<tr>
			<th><label for="wt_test_email"><?php esc_html_e( 'Test Email', 'wp-travel' ) ?></label></th>
			<td><input type="text" value="<?php echo esc_attr( $wt_test_email ) ?>" name="wt_test_email" id="wt_test_email"/>
			<p class="description"><?php esc_html_e( 'Test email address will get test mode payment emails.', 'wp-travel' ) ?></p>
			</td>
		</tr>
	</table>
	<?php do_action( 'wp_travel_below_debug_tab_fields' ); ?>
<?php
}

/**
 * Update Settings post meta fields.
 *
 * @param Array $settings Settings fields.
 * @return Array.
 */
function wp_travel_payment_save_payment_settings( $settings ) {
	if ( ! $settings ) {
		return;
	}
	$wt_test_mode = ( isset( $_POST['wt_test_mode'] ) && '' !== $_POST['wt_test_mode'] ) ? $_POST['wt_test_mode'] : '';
	$wt_test_email = ( isset( $_POST['wt_test_email'] ) && '' !== $_POST['wt_test_email'] ) ? $_POST['wt_test_email'] : '';

	$partial_payment = ( isset( $_POST['partial_payment'] ) && '' !== $_POST['partial_payment'] ) ? $_POST['partial_payment'] : '';
	$minimum_partial_payout = ( isset( $_POST['minimum_partial_payout'] ) && '' !== $_POST['minimum_partial_payout'] ) ? $_POST['minimum_partial_payout'] : WP_TRAVEL_MINIMUM_PARTIAL_PAYOUT;

	$paypal_email = ( isset( $_POST['paypal_email'] ) && '' !== $_POST['paypal_email'] ) ? $_POST['paypal_email'] : '';
	$payment_option_paypal = ( isset( $_POST['payment_option_paypal'] ) && '' !== $_POST['payment_option_paypal'] ) ? $_POST['payment_option_paypal'] : '';

	$settings['wt_test_mode'] = $wt_test_mode;
	$settings['wt_test_email'] = $wt_test_email;
	$settings['partial_payment'] = $partial_payment;
	$settings['minimum_partial_payout'] = $minimum_partial_payout;

	$settings['paypal_email'] = $paypal_email;
	$settings['payment_option_paypal'] = $payment_option_paypal;

	return $settings;
}

/**
 * Add Input field on additional info tab.
 *
 * @param Number $post_id Post ID.
 * @return void
 */
function wp_travel_itinerary_minimum_payout( $post_id ) {
	if ( ! $post_id ) {
		return;
	}
	$settings = wp_travel_get_settings();
	$currency_code = ( isset( $settings['currency'] ) ) ? $settings['currency'] :'';
	$currency_symbol = wp_travel_get_currency_symbol( $currency_code );
	$wp_travel_minimum_partial_payout = wp_travel_get_minimum_partial_payout( $post_id );
	$payout_percent = ( isset( $settings['minimum_partial_payout'] ) && $settings['minimum_partial_payout'] > 0 )? $settings['minimum_partial_payout']  : WP_TRAVEL_MINIMUM_PARTIAL_PAYOUT;
	$trip_price = wp_travel_get_actual_trip_price( $post_id );
?>
	<tr>
		<td><label for="wp-travel-minimum-partial-payout"><?php esc_html_e( 'Minimum Payout', 'wp-travel' ); ?></label></td>
		<td>
			<span class="wp-travel-currency-symbol"><?php esc_html_e( $currency_symbol, 'wp-travel' ); ?></span><input type="number" min="0" step="0.01" name="wp_travel_minimum_partial_payout" id="wp-travel-minimum-partial-payout" value="<?php echo esc_attr( $wp_travel_minimum_partial_payout ); ?>" />
			<span class="description"><?php esc_html_e( 'Default : ' ); echo sprintf( '%s&percnt; of %s%s', esc_html( $payout_percent ), esc_html( $currency_symbol ), esc_html( $trip_price ) ) ?></span>
		</td>
	</tr>
<?php
}

/**
 * Save minimum payout amount.
 *
 * @param Number $post_id Post ID.
 * @return void
 */
function wp_travel_save_minimum_payout_amount( $post_id ) {
	if ( ! $post_id ) {
		return;
	}

	if ( isset( $_POST['wp_travel_minimum_partial_payout'] ) ) {
		$minimum_partial_payout = sanitize_text_field( wp_unslash( $_POST['wp_travel_minimum_partial_payout'] ) );
		update_post_meta( $post_id, 'wp_travel_minimum_partial_payout', $minimum_partial_payout );
	}
}


/*
 * ADMIN COLUMN - HEADERS
 */
add_filter( 'manage_edit-itinerary-booking_columns', 'wp_travel_booking_paypal_columns', 20 );

/**
 * Customize Admin column.
 *
 * @param  Array $booking_columns List of columns.
 * @return Array                  [description]
 */
function wp_travel_booking_paypal_columns( $booking_columns ) {

	$date = $booking_columns['date'];
	unset( $booking_columns['date'] );

	$booking_columns['payment_mode'] = __( 'Payment Mode', 'wp-travel' );
	$booking_columns['payment_status'] = __( 'Payment Status', 'wp-travel' );
	$booking_columns['date'] = $date;
	return $booking_columns;
}

/*
 * ADMIN COLUMN - CONTENT
 */
add_action( 'manage_itinerary-booking_posts_custom_column', 'wp_travel_booking_paypal_manage_columns', 10, 2 );

/**
 * Add data to custom column.
 *
 * @param  String $column_name Custom column name.
 * @param  int 	  $id          Post ID.
 */
function wp_travel_booking_paypal_manage_columns( $column_name, $id ) {
	switch ( $column_name ) {
		case 'payment_status':
			$payment_id = get_post_meta( $id , 'wp_travel_payment_id' , true );
			$booking_option = get_post_meta( $payment_id , 'wp_travel_booking_option' , true );

			$payment_status = get_post_meta( $payment_id , 'wp_travel_payment_status' , true );
			if ( 'booking_only' === $booking_option || '' === $booking_option ) {
				$label_key = 'pending';
				if ( '' === $payment_status ) {
					update_post_meta( $payment_id , 'wp_travel_payment_status' , $label_key );
				}
			} else {
				$label_key = get_post_meta( $payment_id , 'wp_travel_payment_status' , true );
			}
			if ( ! $label_key ) {
				$label_key = 'N/A';
				update_post_meta( $payment_id , 'wp_travel_payment_status' , $label_key );
			}
			$status = wp_travel_get_payment_status();
			echo '<span class="wp-travel-status wp-travel-payment-status" style="background: ' . esc_attr( $status[ $label_key ]['color'], 'wp-travel' ) . ' ">' . esc_attr( $status[ $label_key ]['text'], 'wp-travel' ) . '</span>';
			break;
		case 'payment_mode':
			$mode = wp_travel_get_payment_mode();
			$payment_id = get_post_meta( $id , 'wp_travel_payment_id' , true );
			$label_key = get_post_meta( $payment_id , 'wp_travel_payment_mode' , true );
			if ( ! $label_key ) {
				$label_key = 'N/A';
				update_post_meta( $payment_id , 'wp_travel_payment_mode' , $label_key );
			}
			echo '<span >' . esc_attr( $mode[ $label_key ]['text'], 'wp-travel' ) . '</span>';
			break;
		default:
			break;
	} // end switch
}

/*
 * ADMIN COLUMN - SORTING - MAKE HEADERS SORTABLE
 * https://gist.github.com/906872
 */
// add_filter( 'manage_edit-itinerary-booking_sortable_columns', 'wp_travel_booking_paypal_sort' );
function wp_travel_booking_paypal_sort( $columns ) {

	$custom = array(
		'payment_status' => 'payment_status',
		'payment_mode' 	 => 'payment_mode',
	);
	return wp_parse_args( $custom, $columns );
	/* or this way
		$columns['concertdate'] = 'concertdate';
		$columns['city'] = 'city';
		return $columns;
	*/
}

/*
 * ADMIN COLUMN - SORTING - ORDERBY
 * http://scribu.net/wordpress/custom-sortable-columns.html#comment-4732
 */
add_filter( 'request', 'wp_travel_booking_paypal_column_orderby' );

/**
 * Manage Order By custom column.
 *
 * @param  Array $vars Order By array.
 * @since 1.0.0
 * @return Array       Order By array.
 */
function wp_travel_booking_paypal_column_orderby( $vars ) {
	if ( isset( $vars['orderby'] ) && 'payment_status' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'wp_travel_payment_status',
			'orderby' => 'meta_value',
		) );
	}
	if ( isset( $vars['orderby'] ) && 'payment_mode' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'wp_travel_payment_mode',
			'orderby' => 'meta_value',
		) );
	}
	return $vars;
}

/**
 * Stat Data for Payment.
 *
 * @param Array $chart_data
 * @return void
 */
function wp_travel_payment_stat_data( $chart_data ) {
	if ( ! $chart_data ) {
		return;
	}
	if ( ! isset( $_REQUEST['chart_type'] ) ) {
		return $chart_data;
	}
	if ( isset( $_REQUEST['chart_type'] ) &&  'payment' !== $_REQUEST['chart_type'] ) {
		return $chart_data;
	}
	global $wpdb;

	$initial_load = true;

	// Default variables.
	$query_limit = apply_filters( 'wp_travel_stat_default_query_limit', 10 );
	$limit = "limit {$query_limit}";
	$where = '';
	$groupby = '';

	$from_date = '';
	if ( isset( $_REQUEST['booking_stat_from'] ) && '' !== $_REQUEST['booking_stat_from'] ) {
		$from_date = $_REQUEST['booking_stat_from'];
	}
	$to_date = '';
	if ( isset( $_REQUEST['booking_stat_to'] ) && '' !== $_REQUEST['booking_stat_to'] ) {
		$to_date = $_REQUEST['booking_stat_to'] . ' 23:59:59';
	}
	$country = '';
	if ( isset( $_REQUEST['booking_country'] ) && '' !== $_REQUEST['booking_country'] ) {
		$country = $_REQUEST['booking_country'];
	}

	$itinerary = '';
	if ( isset( $_REQUEST['booking_itinerary'] ) && '' !== $_REQUEST['booking_itinerary'] ) {
		$itinerary = $_REQUEST['booking_itinerary'];
	}

	// Setting conditions.
	if ( '' !== $from_date || '' !== $to_date || '' !== $country || '' !== $itinerary ) {
		// Set initial load to false if there is extra get variables.
		$initial_load = false;
		if ( '' !== $itinerary ) {
			$where 	 .= " and I.itinerary_id={$itinerary} ";
		}
		if ( '' !== $country ) {
			$where   .= " and country='{$country}'";
		}

		if ( '' !== $from_date && '' !== $to_date ) {

			$date_format = 'Y-m-d H:i:s';

			$booking_from = date( $date_format, strtotime( $from_date ) );
			$booking_to   = date( $date_format, strtotime( $to_date ) );

			$where 	 .= " and payment_date >= '{$booking_from}' and payment_date <= '{$booking_to}' ";
		}
		$limit = '';
	}

	// Payment Data Default Query.
	$initial_transient = $results = get_site_transient( '_transient_wt_booking_payment_stat_data' );
	if ( ( ! $initial_load ) || ( $initial_load && ! $results ) ) {
		$query = "Select count( BOOKING.ID ) as no_of_payment, YEAR( payment_date ) as payment_year, Month( payment_date ) as payment_month, DAY( payment_date ) as payment_day, sum( AMT.payment_amount ) as payment_amount from {$wpdb->posts} BOOKING 
		join ( 
			Select distinct( PaymentMeta.post_id ), meta_value as payment_id, PaymentPost.post_date as payment_date from {$wpdb->posts} PaymentPost 
			join {$wpdb->postmeta} PaymentMeta on PaymentMeta.meta_value = PaymentPost.ID    
			WHERE PaymentMeta.meta_key = 'wp_travel_payment_id'
		) PMT on BOOKING.ID = PMT.post_id
		join ( Select distinct( post_id ), meta_value as country from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_country' ) C on BOOKING.ID = C.post_id 
		join ( Select distinct( post_id ), meta_value as itinerary_id from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_post_id' ) I on BOOKING.ID = I.post_id
		join ( Select distinct( post_id ), meta_value as payment_status from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_payment_status' and meta_value = 'paid' ) PSt on PMT.payment_id = PSt.post_id
		join ( Select distinct( post_id ), case when meta_value IS NULL or meta_value = '' then '0' else meta_value
       end as payment_amount from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_payment_amount'  ) AMT on PMT.payment_id = AMT.post_id
		where post_status='publish' and post_type = 'itinerary-booking' {$where}
		group by YEAR( payment_date ), Month( payment_date ), DAY( payment_date ) order by YEAR( payment_date ), Month( payment_date ), DAY( payment_date ) asc {$limit}";
		$results = $wpdb->get_results( $query );
		// set initial load transient for stat data.
		if ( $initial_load && ! $initial_transient ) {
			set_site_transient( '_transient_wt_booking_payment_stat_data', $results );
		}
	}
	// End of Payment Data Default Query.
	$payment_data = array();
	$payment_label = array();
	$date_format = 'jS M, Y';
	$payment_stat_from = $payment_stat_to = date( $date_format );
	$total_sales = 0;

	if ( $results ) {
		foreach ( $results as $result ) {
			$label_date = $result->payment_year . '-' . $result->payment_month . '-' . $result->payment_day;
			$label_date = date( $date_format, strtotime( $label_date ) );
			$payment_data[] = $result->no_of_payment;
			$payment_label[] = $label_date;
			$total_sales += $result->payment_amount;
		}
	}
	$payment_data2[] = array(
		'label' => esc_html__( 'Payment', 'wp-travel' ),
		'backgroundColor' => '#1DFE0E',
		'borderColor' => '#1DFE0E',
		'data' => $payment_data,
		'fill' => false,
	);

	$chart_data['labels'] = json_encode( $payment_label );
	$chart_data['datasets'] = json_encode( $payment_data2 );
	$chart_data['total_sales'] = number_format( $total_sales, 2, '.', '' );
	return $chart_data;
}

/**
 * Clear payment transient.
 * @since 1.0.0
 */
function wp_travel_clear_payment_transient() {
	delete_site_transient( '_transient_wt_booking_payment_stat_data' );
}

function wp_travel_payment_admin_notices() {
	$screen = get_current_screen();
	$screen_id = $screen->id;

	$notice_pages = array(
		'itineraries_page_settings',
		'itineraries_page_booking_chart',
		'edit-itinerary-booking',
		'edit-travel_keywords',
		'edit-travel_locations',
		'edit-itinerary_types',
		'edit-itineraries',
		'itineraries',
		'itinerary-booking',
	);

	if ( in_array( $screen_id, $notice_pages ) ) {
		$notices = array();
		if ( wp_travel_payment_test_mode() ) {
			$notices[] = array(
				'slug' => 'test-mode',
				'message' => sprintf( __( '"WP Travel" plugin is currently in test mode. <a href="%1$s">Click here</a> to disable test mode.', 'wp-travel' ), esc_url( admin_url( 'edit.php?post_type=itineraries&page=settings#wp-travel-tab-content-debug' ) ) ),
			);
		}
		$notices = apply_filters( 'wp_travel_admin_notices', $notices );

		foreach ( $notices as $notice ) {
			add_settings_error( 'wp-travel-notices', 'wp-travel-notice-' . $notice['slug'], $notice['message'], 'updated' );
		}

		settings_errors( 'wp-travel-notices' );
	}
}

function wp_travel_update_payment_status( $post_id ) {
	if ( ! $post_id ) {
		return;
	}
	$payment_id = get_post_meta( $post_id, 'wp_travel_payment_id', true );

	if ( $payment_id ) {
		$payment_status = isset( $_POST['wp_travel_payment_status'] ) ? $_POST['wp_travel_payment_status'] : 'N/A';
		update_post_meta( $payment_id, 'wp_travel_payment_status', $payment_status );
	}
}

add_action( 'wp_travel_after_booking_data_save', 'wp_travel_update_payment_status' );

/**
 * Add Chart Type field to display chart [payment / booking].
 *
 * @return void
 */
function wp_travel_stat_display_field_chart_type() {
	$chart_type = isset( $_REQUEST['chart_type'] ) ? $_REQUEST['chart_type'] : '';
	?>
	<p class="field-group">
		<span class="field-label"><?php esc_html_e( 'Display Chart', 'wp-travel' ); ?>:</span>
		<select name="chart_type" >
			<option value="booking" <?php selected( 'booked', $chart_type ) ?> ><?php esc_html_e( 'Booking', 'wp-travel' ) ?></option>
			<option value="payment" <?php selected( 'payment', $chart_type ) ?> ><?php esc_html_e( 'Payment', 'wp-travel' ) ?></option>
		</select>
	</p>
	<?php
}
add_action( 'wp_travel_before_stat_toolbar_fields', 'wp_travel_stat_display_field_chart_type' );

/**
 * Add Total Sales on Booking stat info box.
 *
 * @return void
 */
function wp_travel_stat_display_sales_data() {
	?>
	<div>
		<strong><big><?php echo esc_attr( wp_travel_get_currency_symbol() ); ?></big><big class="wp-travel-total-sales">0</big></strong><br />
		<p><?php esc_html_e( 'Total Sales', 'wp-travel' ) ?></p>

	</div>
	<?php
}
add_action( 'wp_travel_before_stat_info_box', 'wp_travel_stat_display_sales_data' );
