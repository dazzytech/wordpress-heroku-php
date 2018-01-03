<?php
/**
 * Helper Functions.
 *
 * @package wp-travel/inc
 */

/**
 * Return all Gallery ID of specific post.
 *
 * @param  int $post_id ID f the post.
 * @return array Return gallery ids.
 */
function wp_travel_get_gallery_ids( $post_id ) {
	$gallery_ids = get_post_meta( $post_id, 'wp_travel_itinerary_gallery_ids', true );
	if ( false === $gallery_ids || empty( $gallery_ids ) ) {
		return false;
	}
	return $gallery_ids;
}

/** Return All Settings of WP travel. */
function wp_travel_get_settings() {
	$settings = get_option( 'wp_travel_settings' );
	return $settings;
}

/**
 * Return Trip Code.
 *
 * @param  int $post_id Post ID of post.
 * @return string Returns the trip code.
 */
function wp_travel_get_trip_code( $post_id = null ) {
	if ( ! is_null( $post_id ) ) {
		$wp_travel_itinerary = new WP_Travel_Itinerary( get_post( $post_id ) );
	} else {
		global $post;
		$wp_travel_itinerary = new WP_Travel_Itinerary( $post );
	}

	return $wp_travel_itinerary->get_trip_code();
}

/**
 * Return dropdown.
 *
 * @param  array $args Arguments for dropdown list.
 * @return HTML  return dropdown list.
 */
function wp_travel_get_dropdown_currency_list( $args = array() ) {

	$currency_list = wp_travel_get_currency_list();

	$default = array(
		'id'		=> '',
		'class'		=> '',
		'name'		=> '',
		'option'	=> '',
		'options'	=> '',
		'selected'	=> '',
		);

	$args = array_merge( $default, $args );

	$dropdown = '';
	if ( is_array( $currency_list )  && count( $currency_list ) > 0 ) {
		$dropdown .= '<select name="' . $args['name'] . '" id="' . $args['id'] . '" class="' . $args['class'] . '" >';
		if ( '' != $args['option'] ) {
			$dropdown .= '<option value="" >' . $args['option'] . '</option>';
		}

		foreach ( $currency_list as $key => $currency ) {

			$dropdown .= '<option value="' . $key . '" ' . selected( $args['selected'], $key, false ) . '  >' . $currency . ' (' . wp_travel_get_currency_symbol( $key ) . ')</option>';
		}
		$dropdown .= '</select>';

	}

	return $dropdown;
}

/**
 * Return Tree Form of post Object.
 *
 * @param Object $elements Post Object.
 * @param Int    $parent_id Parent ID of post.
 * @return Object Return Tree Form of post Object.
 */
function wp_travel_build_post_tree( array &$elements, $parent_id = 0 ) {
	$branch = array();

	foreach ( $elements as $element ) {
		if ( $element->post_parent == $parent_id ) {
			$children = wp_travel_build_post_tree( $elements, $element->ID );
			if ( $children ) {
				$element->children = $children;
			}
			$branch[ $element->ID ] = $element;
			unset( $elements[ $element->ID ] );
		}
	}
	return $branch;
}

/**
 * [wp_travel_get_post_hierarchy_dropdown description]
 *
 * @param  [type]  $list_serialized [description].
 * @param  [type]  $selected        [description].
 * @param  integer $nesting_level   [description].
 * @param  boolean $echo            [description].
 * @return [type]                   [description]
 */
function wp_travel_get_post_hierarchy_dropdown( $list_serialized, $selected, $nesting_level = 0, $echo = true ) {
	$contents = '';
	if ( $list_serialized ) :

		$space = '';
		for ( $i = 1; $i <= $nesting_level; $i ++ ) {
			$space .= '&nbsp;&nbsp;&nbsp;';
		}

		foreach ( $list_serialized as $content ) {

			$contents .= '<option value="' . $content->ID . '" ' . selected( $selected, $content->ID, false ) . ' >' . $space . $content->post_title . '</option>';
			if ( isset( $content->children ) ) {
				$contents .= wp_travel_get_post_hierarchy_dropdown( $content->children, $selected, ( $nesting_level + 1 ) , false );
			}
		}
	endif;
	if ( ! $echo ) {
		return $contents;
	}
	echo $contents;
	return false;
}

/**
 * Get Map Data.
 */
function get_wp_travel_map_data() {
	global $post;
	$lat = ( '' != get_post_meta( $post->ID, 'wp_travel_lat', true ) ) ? get_post_meta( $post->ID, 'wp_travel_lat', true ) :'';
	$lng = ( '' != get_post_meta( $post->ID, 'wp_travel_lng', true ) ) ? get_post_meta( $post->ID, 'wp_travel_lng', true ) : '';
	$loc = ( '' != get_post_meta( $post->ID, 'wp_travel_location', true ) ) ? get_post_meta( $post->ID, 'wp_travel_location', true ) : '';

	$map_meta = array(
		'lat' => $lat,
		'lng' => $lng,
		'loc' => $loc,
		);
	return $map_meta;
}

/**
 * Return Related post HTML.
 *
 * @param Number $post_id Post ID of current post.
 * @return void
 */
function wp_travel_get_related_post( $post_id ) {

	if ( ! $post_id ) {
		return;
	}

	/* TODO: Add global Settings to show/hide related post. */

	$settings = wp_travel_get_settings();
	$hide_related_itinerary = ( isset( $settings['hide_related_itinerary'] ) && '' !== $settings['hide_related_itinerary'] ) ? $settings['hide_related_itinerary'] : 'no';

	if ( 'yes' === $hide_related_itinerary ) {
		return;
	}
	$currency_code 	= ( isset( $settings['currency'] ) ) ? $settings['currency'] : '';
	$currency_symbol = wp_travel_get_currency_symbol( $currency_code );

	// For use in the loop, list 5 post titles related to first tag on current post.
	$terms = wp_get_object_terms( $post_id, 'itinerary_types' );

	$no_related_post_message = '<p class="wp-travel-no-detail-found-msg">' . esc_html__( 'Related itineraries not found.', 'wp-travel' ) . '</p>';
	?>
	 <div class="wp-travel-related-posts wp-travel-container-wrap">
		 <h2><?php echo apply_filters( 'wp_travel_related_post_title', esc_html__( 'Related Itineraries', 'wp-travel' ) ); ?></h2>
		<div class="wp-travel-itinerary-items"> 
			 <?php
		 	if ( ! empty( $terms ) ) {
				$term_ids = wp_list_pluck( $terms, 'term_id' );
				$col_per_row = apply_filters( 'wp_travel_related_itineraries_col_per_row' , '3' );
				$args = array(
					'post_type' => 'itineraries',
					'post__not_in' => array( $post_id ),
					'posts_per_page' => $col_per_row,
					'tax_query' => array(
						array(
							'taxonomy' => 'itinerary_types',
							'field' => 'id',
							'terms' => $term_ids,
						),
					),
				);
				$query = new WP_Query( $args );
			if ( $query->have_posts() ) { ?>
				
				<ul style="grid-template-columns:repeat(<?php esc_attr_e( $col_per_row, 'wp-travel') ?>, 1fr)" class="wp-travel-itinerary-list">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php wp_travel_get_template_part( 'shortcode/itinerary', 'item' ); ?>
					<?php endwhile; ?>
				</ul>
			<?php
			} else {
				wp_travel_get_template_part( 'shortcode/itinerary', 'item-none' );
			}
			wp_reset_query();
	 } else {
		wp_travel_get_template_part( 'shortcode/itinerary', 'item-none' );
	 }
	 ?>
	 </div>
	 </div>
	 <?php
}

/**
 * Return Trip Price.
 *
 * @param  int $post_id Post id of the post.
 * @return int Trip Price.
 */
function wp_travel_get_trip_price( $post_id = 0 ) {
	if ( ! $post_id ) {
		return 0;
	}
	$trip_price 	= get_post_meta( $post_id, 'wp_travel_price', true );
	if ( $trip_price ) {
		return $trip_price;
	}
	return 0;
}

/**
 * Return Trip Sale Price.
 *
 * @param  int $post_id Post id of the post.
 * @return int Trip Price.
 */
function wp_travel_get_trip_sale_price( $post_id = 0 ) {
	if ( ! $post_id ) {
		return 0;
	}
	$trip_sale_price 	= get_post_meta( $post_id, 'wp_travel_sale_price', true );
	if ( $trip_sale_price ) {
		return $trip_sale_price;
	}
	return 0;
}

/**
 * Return Trip Price.
 *
 * @param  int $post_id Post id of the post.
 *
 * @since 1.0.5
 * @return int Trip Price.
 */
function wp_travel_get_actual_trip_price( $post_id = 0 ) {
	if ( ! $post_id ) {
		return 0;
	}

	$trip_price = get_post_meta( $post_id, 'wp_travel_trip_price', true );
	if ( ! $trip_price ) {
		$enable_sale 	= get_post_meta( $post_id, 'wp_travel_enable_sale', true );

		if ( $enable_sale ) {
			$trip_price = wp_travel_get_trip_sale_price( $post_id );
		} else {
			$trip_price = wp_travel_get_trip_price( $post_id );
		}
	}
	return $trip_price;
}

/**
 * Get post thumbnail.
 *
 * @param  int    $post_id Post ID.
 * @param  string $size    Image size.
 * @return string          Image tag.
 */
function wp_travel_get_post_thumbnail( $post_id, $size = 'post-thumbnail' ) {
	if ( ! $post_id ) {
		global $post;
		$post_id = $post->ID;
	}
	$size = apply_filters( 'wp_travel_itinerary_thumbnail_size', $size );
	$thumbnail = get_the_post_thumbnail( $post_id, $size );

	if ( ! $thumbnail ) {
		$placeholder_image_url = wp_travel_get_post_placeholder_image_url();
		$thumbnail = '<img width="100%" height="100%" src="' . $placeholder_image_url . '">';
	}
	return $thumbnail;
}

/**
 * Get post thumbnail URL.
 *
 * @param  int    $post_id Post ID.
 * @param  string $size    Image size.
 * @return string          Image URL.
 */
function wp_travel_get_post_thumbnail_url( $post_id, $size = 'post-thumbnail' ) {
	if ( ! $post_id ) {
		return;
	}
	$thumbnail = get_the_post_thumbnail_url( $post_id, $size );

	if ( ! $thumbnail ) {
		$thumbnail = wp_travel_get_post_placeholder_image_url();
	}
	return $thumbnail;
}

/**
 * Post palceholder image URL.
 *
 * @return string Placeholder image URL.
 */
function wp_travel_get_post_placeholder_image_url() {
	$thumbnail_url = plugins_url( '/wp-travel/assets/images/wp-travel-placeholder.png' );
	return $thumbnail_url;
}

/**
 * Allowed tags.
 *
 * @param array $tags filter tags.
 * @return array allowed tags.
 */
function wp_travel_allowed_html( $tags = array() ) {

	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'dl' => array(),
		'dt' => array(),
		'em' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'i' => array(),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
		),
		'ol' => array(
			'class' => array(),
		),
		'p' => array(
			'class' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
		),
	);

	if ( ! empty( $tags ) ) {
		$output = array();
		foreach ( $tags as $key ) {
			if ( array_key_exists( $key, $allowed_tags ) ) {
				$output[ $key ] = $allowed_tags[ $key ];
			}
		}
		return $output;
	}
	return $allowed_tags;
}

/**
 * Return array list of itinerary.
 *
 * @return Array
 */
function wp_travel_get_itineraries_array() {
	$args = array(
	  'post_type'   => 'itineraries',
	);

	$itineraries = get_posts( $args );

	$itineraries_array = array();
	foreach ( $itineraries as $itinerary ) {
		$itineraries_array[ $itinerary->ID ] = $itinerary->post_title;
	}
	return apply_filters( 'wp_travel_itineraries_array', $itineraries_array, $args );
}

/**
 * Return WP Travel Featured post.
 *
 * @param integer $no_of_post_to_show No of post to show.
 * @return array
 */
function wp_travel_featured_itineraries( $no_of_post_to_show = 3 ) {
	$args = array(
		'numberposts' => $no_of_post_to_show,
		'offset'           => 0,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'meta_key'         => 'wp_travel_featured',
		'meta_value'       => 'yes',
		'post_type'        => 'itineraries',
		'post_status'      => 'publish',
		'suppress_filters' => true,
	);
	$posts_array = get_posts( $args );
	return $posts_array;
}


/**
 * Show WP Travel search form.
 *
 * @since  1.0.2
 */
function wp_travel_search_form() {
	ob_start(); ?>
	<div class="wp-travel-search">
		<form method="get" name="wp-travel_search" action="<?php echo esc_url( home_url( '/' ) );  ?>" > 
			<input type="hidden" name="post_type" value="itineraries" />
			<p>
				<label><?php esc_html_e( 'Search:', 'wp-travel' ) ?></label>
				<?php $placeholder = __( 'Ex: Trekking', 'wp-travel' ); ?>
				<input type="text" name="s" id="s" value="<?php echo ( isset( $_GET['s'] ) ) ? esc_textarea( $_GET['s'] ) : ''; ?>" placeholder="<?php echo esc_attr( apply_filters( 'wp_travel_search_placeholder', $placeholder ) ); ?>">
			</p>
			<p>
				<label><?php esc_html_e( 'Trip Type:', 'wp-travel' ) ?></label>
				<?php
				$taxonomy = 'itinerary_types';
				$args = array(
					'show_option_all'    => __( 'All', 'wp-travel' ),
					'hide_empty'         => 0,
					'selected'           => 1,
					'hierarchical'       => 1,
					'name'               => $taxonomy,
					'class'              => 'wp-travel-taxonomy',
					'taxonomy'           => $taxonomy,
					'selected'           => ( isset( $_GET[$taxonomy] ) ) ? esc_textarea( $_GET[$taxonomy] ) : 0,
					'value_field'		 => 'slug',
				);

				wp_dropdown_categories( $args, $taxonomy );
				?>
			</p>
			<p>
				<label><?php esc_html_e( 'Location:', 'wp-travel' ) ?></label>
				<?php
				$taxonomy = 'travel_locations';
				$args = array(
					'show_option_all'    => __( 'All', 'wp-travel' ),
					'hide_empty'         => 0,
					'selected'           => 1,
					'hierarchical'       => 1,
					'name'               => $taxonomy,
					'class'              => 'wp-travel-taxonomy',
					'taxonomy'           => $taxonomy,
					'selected'           => ( isset( $_GET[$taxonomy] ) ) ? esc_textarea( $_GET[$taxonomy] ) : 0,
					'value_field'		 => 'slug',
				);

				wp_dropdown_categories( $args, $taxonomy );
				?>
			</p>
			
			<p class="wp-travel-search"><input type="submit" name="wp-travel_search" id="wp-travel-search" class="button button-primary" value="<?php esc_html_e( 'Search', 'wp-travel' ) ?>"  /></p>
		</form>
	</div>	
	<?php
	$content = apply_filters( 'wp_travel_search_form', ob_get_clean() );
	echo $content;
}

/**
 * This will optput Trip duration HTML
 *
 * @param int $post_id Post ID.
 * @return void
 */
function wp_travel_get_trip_duration( $post_id ) {
		if ( ! $post_id ) {
			return;
		}

		$fixed_departure = get_post_meta( $post_id, 'wp_travel_fixed_departure', true );
		$fixed_departure = ( $fixed_departure ) ? $fixed_departure : 'yes';
		$fixed_departure = apply_filters( 'wp_travel_fixed_departure_defalut', $fixed_departure );
	?>
	<?php if ( 'yes' === $fixed_departure ) : ?>
		<?php
			$start_date	= get_post_meta( $post_id, 'wp_travel_start_date', true );
			$end_date 	= get_post_meta( $post_id, 'wp_travel_end_date', true );
		?>
			
		<div class="wp-travel-trip-time trip-fixed-departure">
			<i class="fa fa-calendar"></i>
			<span class="wp-travel-trip-duration">
				<?php if ( $start_date && $end_date ) : ?>
					<?php $date_format = get_option( 'date_format' ); ?>
					<?php if ( ! $date_format ) : ?>
						<?php $date_format = 'jS M, Y'; ?>
					<?php endif; ?>
					<?php printf( '%s - %s', date( $date_format, strtotime( $start_date ) ), date( $date_format, strtotime( $end_date ) ) ); ?> 
				<?php else : ?>
					<?php esc_html_e( 'N/A', 'wp-travel' ); ?>
				<?php endif; ?>
			</span>
		</div>
		
	<?php else : ?>
		<?php
		$trip_duration = get_post_meta( $post_id, 'wp_travel_trip_duration', true );
		$trip_duration = ( $trip_duration ) ? $trip_duration : 0; ?>
		
		<div class="wp-travel-trip-time trip-duration">
			<i class="fa fa-clock-o"></i>
			<span class="wp-travel-trip-duration">
				<?php if ( ( int ) $trip_duration > 0 ) : ?>
					<?php echo esc_html( $trip_duration . ' Days' ); ?>
				<?php else : ?>
					<?php esc_html_e( 'N/A', 'wp-travel' ); ?>
				<?php endif; ?>
			</span>
		</div>
	<?php endif;
}

/**
 * Return price per fields.
 *
 * @since 1.0.5
 * @return array
 */
function wp_travel_get_price_per_fields() {
	$price_per = array(
		'person' => __( 'Person', 'wp-travel' ),
		'group'	 => __( 'Group', 'wp-travel' ),
	);

	return apply_filters( 'wp_travel_price_per_fields', $price_per );
}

/**
 * Get Price Per text.
 *
 * @param Number $post_id Current post id.
 * @since 1.0.5
 */
function wp_travel_get_price_per_text( $post_id ) {
	if ( ! $post_id ) {
		return;
	}
	$per_person_text = get_post_meta( $post_id, 'wp_travel_price_per', true );
	if ( ! $per_person_text ) {
		$per_person_text = 'person';
	}
	return $per_person_text;
}

/**
 * Check sale price enable or not.
 *
 * @param Number $post_id Current post id.
 * @since 1.0.5
 */
function wp_travel_is_enable_sale( $post_id ) {
	if ( ! $post_id ) {
		return false;
	}
	$enable_sale 	= get_post_meta( $post_id, 'wp_travel_enable_sale', true );

	if ( $enable_sale  ) {
		return true;
	}
	return false;
}

/**
 * Get All Data Needed for booking stat.
 *
 * @since 1.0.5
 * @return Array
 */
function wp_travel_get_booking_data() {
	global $wpdb;

	$initial_load = true;

	// Default variables.
	$query_limit = apply_filters( 'wp_travel_stat_default_query_limit', 10 );
	$limit = "limit {$query_limit}";
	$where = '';
	$top_country_where = '';
	$top_itinerary_where = '';
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
			$where 	 .= " and itinerary_id={$itinerary} ";
			$top_country_where .= $where;
			$groupby .= ' itinerary_id,';
		}
		if ( '' !== $country ) {
			$where   .= " and country='{$country}'";
			$top_itinerary_where .= " and country='{$country}'";
			$groupby .= ' country,';
		}

		if ( '' !== $from_date && '' !== $to_date ) {

			$date_format = 'Y-m-d H:i:s';

			$booking_from = date( $date_format, strtotime( $from_date ) );
			$booking_to   = date( $date_format, strtotime( $to_date ) );

			$where 	 .= " and post_date >= '{$booking_from}' and post_date <= '{$booking_to}' ";
			$top_country_where .= " and post_date >= '{$booking_from}' and post_date <= '{$booking_to}' ";
			$top_itinerary_where .= " and post_date >= '{$booking_from}' and post_date <= '{$booking_to}' ";
		}
		$limit = '';
	}

	// Booking Data Default Query.
	$initial_transient = $results = get_site_transient( '_transient_wt_booking_stat_data' );
	if ( ( ! $initial_load ) || ( $initial_load && ! $results ) ) {
		$query = "SELECT count(ID) as no_of_booking, YEAR(post_date) as booked_year, MONTH(post_date) as booked_month, DAY(post_date) as booked_day, sum(no_of_pax) as no_of_pax
		from (
			Select P.ID, P.post_date, P.post_type, P.post_status, C.country, I.itinerary_id, PAX.no_of_pax from {$wpdb->posts} P 
			join ( Select distinct( post_id ), meta_value as country from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_country' ) C on P.ID = C.post_id 
			join ( Select distinct( post_id ), meta_value as itinerary_id from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_post_id' ) I on P.ID = I.post_id
			join ( Select distinct( post_id ), meta_value as no_of_pax from  {$wpdb->postmeta} WHERE meta_key = 'wp_travel_pax' ) PAX on P.ID = PAX.post_id
			group by P.ID, C.country, I.itinerary_id, PAX.no_of_pax
		) Booking 
		where post_type='itinerary-booking' AND post_status='publish' {$where} group by {$groupby} YEAR(post_date), MONTH(post_date), DAY(post_date) {$limit}";
		$results =  $wpdb->get_results( $query );
		// set initial load transient for stat data.
		if ( $initial_load && ! $initial_transient ) {
			set_site_transient( '_transient_wt_booking_stat_data', $results );
		}
	}

	$stat_data = array();
	$date_format = 'jS M, Y';

	$max_bookings = 0;
	$max_pax = 0;
	$booking_stat_from = $booking_stat_to = date( $date_format );
	if ( is_array( $results ) && count( $results ) > 0 ) {
		foreach ( $results as $result ) {
			$label_date = $result->booked_year . '-' . $result->booked_month . '-' . $result->booked_day;
			$label_date = date( $date_format, strtotime( $label_date ) );

			$stat_data['data'][] = $result->no_of_booking;
			$stat_data['labels'][] = $label_date;

			$max_bookings += ( int ) $result->no_of_booking;
			$max_pax += ( int ) $result->no_of_pax;

			if ( strtotime( $booking_stat_from ) > strtotime( $label_date ) ) {

				$booking_stat_from = date( 'm/d/Y', strtotime( $label_date ) );
			}

			if ( strtotime( $booking_stat_to ) < strtotime( $label_date ) ) {
				$booking_stat_to = date( 'm/d/Y', strtotime( $label_date ) );
			}
		}
	}
	if ( '' !== $from_date ) {
		$booking_stat_from = date( 'm/d/Y', strtotime( $from_date ) );
	}

	if ( '' !== $to_date ) {
		$booking_stat_to = date( 'm/d/Y', strtotime( $to_date ) );
	}

	// End of Booking Data Default Query.
	// Query for top country.
	$initial_transient = $results = get_site_transient( '_transient_wt_booking_top_country' );
	if ( ( ! $initial_load ) || ( $initial_load && ! $results ) ) {
		$top_country_query = "SELECT count(ID) as no_of_booking, country
		from (
			Select P.ID, P.post_date, P.post_type, P.post_status, C.country, I.itinerary_id from  {$wpdb->posts} P 
			join ( Select distinct( post_id ), meta_value as country from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_country' and meta_value != '' ) C on P.ID = C.post_id
			join ( Select distinct( post_id ), meta_value as itinerary_id from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_post_id' ) I on P.ID = I.post_id
			group by P.ID, C.country, I.itinerary_id
		) Booking 
		where post_type='itinerary-booking' AND post_status='publish' {$where}  group by country order by no_of_booking desc";

		$top_countries = array();
		$results =  $wpdb->get_results( $top_country_query );
		// set initial load transient for stat data.
		if ( $initial_load && ! $initial_transient ) {
			set_site_transient( '_transient_wt_booking_top_country', $results );
		}
	}

	if ( is_array( $results ) && count( $results ) > 0 ) {
		foreach ( $results as $result ) {
			$top_countries[] = $result->country;
		}
	}
	// End of query for top country.
	// Query for top Itinerary.
	$initial_transient = $results = get_site_transient( '_transient_wt_booking_top_itinerary' );
	if ( ( ! $initial_load ) || ( $initial_load && ! $results ) ) {
		$top_itinerary_query = "SELECT count(ID) as no_of_booking, itinerary_id
		from (
			Select P.ID, P.post_date, P.post_type, P.post_status, C.country, I.itinerary_id from  {$wpdb->posts} P 
			join ( Select distinct( post_id ), meta_value as country from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_country' and meta_value != '' ) C on P.ID = C.post_id
			join ( Select distinct( post_id ), meta_value as itinerary_id from {$wpdb->postmeta} WHERE meta_key = 'wp_travel_post_id' ) I on P.ID = I.post_id
			group by P.ID, C.country, I.itinerary_id
		) Booking 
		where post_type='itinerary-booking' AND post_status='publish' {$where}  group by itinerary_id order by no_of_booking desc";

		$results =  $wpdb->get_results( $top_itinerary_query );
		// set initial load transient for stat data.
		if ( $initial_load && ! $initial_transient ) {
			set_site_transient( '_transient_wt_booking_top_itinerary', $results );
		}
	}
	$top_itinerary = array( 'name' => esc_html__( 'N/A', 'wp-travel' ), 'url' => '' );
	if ( is_array( $results ) && count( $results ) > 0 ) {
		$itinerary_id = $results['0']->itinerary_id;

		if ( $itinerary_id ) {
			$top_itinerary['name'] = get_the_title( $itinerary_id );
			$top_itinerary['id'] = $itinerary_id;
		}
	}
	// End of query for top Itinerary.
	$stat_data['max_bookings']  = $max_bookings;
	$stat_data['max_pax']       = $max_pax;
	$stat_data['top_countries'] = wp_travel_get_country_by_code( $top_countries );
	$stat_data['top_itinerary'] = $top_itinerary;

	$stat_data['booking_stat_from'] = $booking_stat_from;
	$stat_data['booking_stat_to'] = $booking_stat_to;

	return $stat_data;
}

/**
 * Get Booking Status List.
 *
 * @since 1.0.5
 */
function wp_travel_get_booking_status() {
	$status = array(
		'pending' => array( 'color' => '#FF9800', 'text' => __( 'Pending', 'wp-travel' ) ),
		'booked' => array( 'color' => '#008600', 'text' => __( 'Booked', 'wp-travel' ) ),
		'canceled' => array( 'color' => '#FE450E', 'text' => __( 'Canceled', 'wp-travel' ) ),
		'N/A' => array( 'color' => '#892E2C', 'text' => __( 'N/A', 'wp-travel' ) ),
	);

	return apply_filters( 'wp_travel_booking_status_list', $status );
}

/**
 * Get Payment Status List.
 *
 * @since 1.0.6
 */
function wp_travel_get_payment_status() {
	$status = array(
		'pending' => array( 'color' => '#FF9800', 'text' => __( 'Pending', 'wp-travel' ) ),
		'paid' => array( 'color' => '#008600', 'text' => __( 'Paid', 'wp-travel' ) ),
		'canceled' => array( 'color' => '#FE450E', 'text' => __( 'Canceled', 'wp-travel' ) ),
		'N/A' => array( 'color' => '#892E2C', 'text' => __( 'N/A', 'wp-travel' ) ),
	);

	return apply_filters( 'wp_travel_payment_status_list', $status );
}

/**
 * Get Payment Mode List.
 *
 * @since 1.0.5
 */
function wp_travel_get_payment_mode() {
	$mode = array(
		'partial' => array( 'color' => '#FF9F33', 'text' => __( 'Partial', 'wp-travel' ) ),
		'full' => array( 'color' => '#FF8A33', 'text' => __( 'Full', 'wp-travel' ) ),
		'N/A' => array( 'color' => '#892E2C', 'text' => __( 'N/A', 'wp-travel' ) ),
	);

	return apply_filters( 'wp_travel_payment_mode_list', $mode );
}
