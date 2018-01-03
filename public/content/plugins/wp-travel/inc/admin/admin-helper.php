<?php

/*
 * ADMIN COLUMN - HEADERS
 */
add_filter( 'manage_edit-itineraries_columns', 'wp_travel_itineraries_columns' );

/**
 * Customize Admin column.
 *
 * @param  Array $booking_columns List of columns.
 * @return Array                  [description]
 */
function wp_travel_itineraries_columns( $itinerary_columns ) {

	$date = $itinerary_columns['date'];
	unset( $itinerary_columns['date'] );

	$itinerary_columns['booking_count'] = __( 'Booking Count', 'wp-travel' );
	$itinerary_columns['featured'] = __( 'Featured', 'wp-travel' );
	$itinerary_columns['date'] = __( 'Date', 'wp-travel' );
	return $itinerary_columns;
}

/*
 * ADMIN COLUMN - CONTENT
 */
add_action( 'manage_itineraries_posts_custom_column', 'wp_travel_itineraries_manage_columns', 10, 2 );

/**
 * Add data to custom column.
 *
 * @param  String $column_name Custom column name.
 * @param  int 	  $id          Post ID.
 */
function wp_travel_itineraries_manage_columns( $column_name, $id ) {
	switch ( $column_name ) {
		case 'booking_count':
			$booking_count = get_post_meta( $id, 'wp_travel_booking_count', true );
			echo ( isset( $booking_count ) && '' != $booking_count ) ? $booking_count : 0;
			break;
		case 'featured':
			$featured = get_post_meta( $id, 'wp_travel_featured', true );
			$featured = ( isset( $featured ) && '' != $featured ) ? $featured : 'no';

			$icon_class = ' dashicons-star-empty ';
			if ( ! empty( $featured ) && 'yes' === $featured ){
				$icon_class = ' dashicons-star-filled ';
			}
			$nonce = wp_create_nonce( 'wp_travel_featured_nounce' );
			printf( '<a href="#" class="wp-travel-featured-post dashicons %s" data-post-id="%d"  data-nonce="%s"></a>', $icon_class, $id, $nonce );
			break;
		default:
			break;
	} // end switch
}

/*
 * ADMIN COLUMN - SORTING - MAKE HEADERS SORTABLE
 * https://gist.github.com/906872
 */
add_filter( 'manage_edit-itineraries_sortable_columns', 'wp_travel_itineraries_sort' );
function wp_travel_itineraries_sort( $columns ) {

	$custom = array(
		'booking_count' 	=> 'booking_count',
	);
	return wp_parse_args( $custom, $columns );
}

/*
 * ADMIN COLUMN - SORTING - ORDERBY
 * http://scribu.net/wordpress/custom-sortable-columns.html#comment-4732
 */
add_filter( 'request', 'wp_travel_itineraries_column_orderby' );

/**
 * Manage Order By custom column.
 *
 * @param  Array $vars Order By array.
 * @return Array       Order By array.
 */
function wp_travel_itineraries_column_orderby( $vars ) {
	if ( isset( $vars['orderby'] ) && 'booking_count' == $vars['orderby'] ) {
		$vars = array_merge( $vars, array(
			'meta_key' => 'wp_travel_booking_count',
			'orderby' => 'meta_value',
		) );
	}
	return $vars;
}



/**
 * Ajax for adding feature aditem.
 *
 */
function wp_travel_featured_admin_ajax() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'wp_travel_featured_nounce' ) ) {
	  exit( 'invalid' );
	}

    header('Content-Type: application/json');
    $post_id = intval( $_POST['post_id'] );
    $featuredStatus = esc_attr(get_post_meta( $post_id, 'wp_travel_featured', true ));
    $newStatus = $featuredStatus == 'yes' ? 'no' : 'yes';
    update_post_meta($post_id, 'wp_travel_featured', $newStatus);
    echo json_encode( array(
        'ID' => $post_id,
        'new_status' => $newStatus,
    ) );
    die();
}
add_action( 'wp_ajax_wp_travel_featured_post', 'wp_travel_featured_admin_ajax' );


add_action( 'post_submitbox_misc_actions', 'wp_travel_publish_metabox' );
// add_action( 'save_post', 'save_article_or_box' );
function wp_travel_publish_metabox() {
	global $post;
	if ( get_post_type( $post ) === 'itinerary-booking' ) {
	?>
		<div class="misc-pub-section misc-pub-booking-status">
			<?php
			$status = wp_travel_get_booking_status();
			$label_key = get_post_meta( $post->ID, 'wp_travel_booking_status', true );
			?>
			
			<label for="wp-travel-post-id"><?php esc_html_e( 'Booking Status', 'wp-travel' ); ?></label>
			<select id="wp_travel_booking_status" name="wp_travel_booking_status" >
			<?php foreach ( $status as $value => $st ) : ?>
				<option value="<?php echo esc_html( $value ); ?>" <?php selected( $value, $label_key ) ?>>
					<?php echo esc_html( $status[ $value ]['text'] ); ?>
				</option>
			<?php endforeach; ?>
			</select>
		</div>
        
	<?php
    }
}
