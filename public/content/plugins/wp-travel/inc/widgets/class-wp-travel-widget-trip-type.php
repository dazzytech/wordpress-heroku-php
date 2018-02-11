<?php
/**
 * Exit if accessed directly.
 *
 * @package wp-travel\incldues\widgets
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Aditem Search Widget.
 *
 * @author   WenSolutions
 * @category Widgets
 * @package  wp-travel/Widgets
 * @extends  WP_Widget
 */
class WP_Travel_Widget_Trip_Type extends WP_Widget {

	private $no_of_trip_show;
	private $trip_per_row;
	/**
	 * Constructor.
	 */
	function __construct() {
		// Instantiate the parent object.
		parent::__construct( false, __( 'WP Travel Trips by Type', 'wp-travel' ) );
		$this->no_of_trip_show = 2;
		$this->trip_per_row = 1;
	}

	/**
	 * Display widget.
	 *
	 * @param  Mixed $args     Arguments of widget.
	 * @param  Mixed $instance Instance value of widget.
	 */
	function widget( $args, $instance ) {

		extract( $args );
		// These are the widget options.
		$title = $instance['title'];
		$hide_title = isset( $instance['hide_title'] ) ? $instance['hide_title'] : '';
		$no_of_trip_show = ( $instance['no_of_trip_show'] ) ? $instance['no_of_trip_show'] : $this->no_of_trip_show;
		// $trip_per_row = ( $instance['trip_per_row'] ) ? $instance['trip_per_row'] : $this->trip_per_row;
		$trip_type = ( $instance['trip_type'] ) ? $instance['trip_type'] : '';
		echo $before_widget;
		if ( ! $hide_title ) {
			echo ( $title ) ? $before_title . $title . $after_title : '';
		}
		$args = array(
			'numberposts' 	   => $no_of_trip_show,
			'offset'           => 0,
			'orderby'          => 'date',
			'order'            => 'DESC',			
			'post_type'        => 'itineraries',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		);
		if ( $trip_type ) {
			$args['tax_query'] = array(
				array(
				  'taxonomy' => 'itinerary_types',
				  'field' => 'id',
				  'terms' => $trip_type, // Where term_id of Term 1 is "1".
				  'include_children' => false,
				),
			);
		}
		$itineraries = get_posts( $args ); ?>

		<?php if ( count( $itineraries ) > 0 ) : ?>
			<ul class="wp-travel-itinerary-widget trip-type-widget">
			<?php foreach ( $itineraries as $itinerary ) : ?>				
				<li class="col-<?php echo esc_attr( $this->trip_per_row, 'wp-travel' )?>-per-row clearfix">
					<?php echo wp_travel_get_post_thumbnail( $itinerary->ID, 'wp_travel_thumbnail' ) ?>
					
					<div class="wp-travel-itinerary-info">
						<a href="<?php the_permalink( $itinerary->ID ); ?>" class="wp-travel-title">
							<?php echo esc_html( $itinerary->post_title, 'wp-travel' ) ?>
						</a>
						<?php if ( wp_travel_is_enable_sale( $itinerary->ID ) ) : ?>
							<del>
								<span class="wp-travel-del-price"><?php printf( '%s %s', esc_html( wp_travel_get_currency_symbol() ), esc_html( wp_travel_get_trip_price( $itinerary->ID ) ) ) ?></span>
							</del>
						<?php endif; ?>
						<span class="wp-travel-trip-price"><?php printf( '%s %s', esc_html( wp_travel_get_currency_symbol() ), esc_html( wp_travel_get_actual_trip_price( $itinerary->ID ) ) ) ?></span>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="itinerary-none"><?php esc_html_e( 'Itinerary not found.', 'wp-travel' ) ?></p>
		<?php endif;
		echo $after_widget;
	}
	/**
	 * Update widget.
	 *
	 * @param  Mixed $new_instance New instance of widget.
	 * @param  Mixed $old_instance Old instance of widget.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['hide_title'] = isset( $new_instance['hide_title'] ) ? sanitize_text_field( $new_instance['hide_title'] ) : '';
		// $instance['trip_per_row'] = sanitize_text_field( $new_instance['trip_per_row'] );
		$instance['no_of_trip_show'] = sanitize_text_field( $new_instance['no_of_trip_show'] );
		$instance['trip_type'] = sanitize_text_field( $new_instance['trip_type'] );
		return $instance;
	}

	/**
	 * Search form of widget.
	 *
	 * @param  Mixed $instance Widget instance.
	 */
	function form( $instance ) {
		// Check values.
		$title = '';
		$hide_title = '';
		$no_of_trip_show = $this->no_of_trip_show;
		$trip_per_row = $this->trip_per_row;
		$trip_type = '';
		if ( isset( $instance['title'] ) ) {
			$title = esc_attr( $instance['title'] );
		}
		if ( isset( $instance['hide_title'] ) ) {
			$hide_title = esc_attr( $instance['hide_title'] );
		}
		// if ( $instance['trip_per_row'] ) {
		// 	$trip_per_row = esc_attr( $instance['trip_per_row'] );
		// }
		if ( isset( $instance['no_of_trip_show'] ) ) {
			$no_of_trip_show = esc_attr( $instance['no_of_trip_show'] );
		}

		if ( isset( $instance['trip_type'] ) ) {
			$trip_type = esc_attr( $instance['trip_type'] );
		} ?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', 'wp-travel' ); ?>:</label>
			<input type="text" value="<?php echo esc_attr( $title ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" class="widefat">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'no_of_trip_show' ) ); ?>"><?php esc_html_e( 'No. of trip to show', 'wp-travel' ); ?>:</label>
			<input type="number" value="<?php echo esc_attr( $no_of_trip_show ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'no_of_trip_show' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'no_of_trip_show' ) ); ?>" min="1" max="100" class="widefat">
		</p>
		<!-- <p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'trip_per_row' ) ); ?>"><?php esc_html_e( 'Trip per row', 'wp-travel' ); ?>:</label>
			<input type="number" value="<?php echo esc_attr( $trip_per_row ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'trip_per_row' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'trip_per_row' ) ); ?>" min="1" max="9" class="widefat">
		</p> -->
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>"><?php esc_html_e( 'Hide title', 'wp-travel' ); ?>:</label>
			<label style="display: block;"><input type="checkbox" value="1" name="<?php echo esc_attr( $this->get_field_name( 'hide_title' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'hide_title' ) ); ?>" class="widefat" <?php checked( 1, $hide_title ); ?>><?php esc_html_e( 'Check to Hide', 'wp-travel' ); ?></label>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'trip_type' ) ); ?>"><?php esc_html_e( 'Select Trip Type', 'wp-travel' ); ?>:</label>
			<?php
				$args = array(
					'show_option_none'   => __( 'All', 'wp-travel' ),
					'option_none_value'  => '',
					'taxonomy'           => 'itinerary_types',
					'hide_if_empty'      => false,
					'value_field'	     => 'term_id',
					'class'				 => 'widefat',
					'id'				 => $this->get_field_id( 'trip_type' ),
					'selected' 			 => $trip_type,
					'name'				 => $this->get_field_name( 'trip_type' ),
				);
				wp_dropdown_categories( $args ); ?>
		</p>
	<?php
	}
}

/**
 * Register Widgets.
 *
 * @return void
 */
function wp_travel_register_trip_type_widgets() {
	register_widget( 'WP_Travel_Widget_Trip_Type' );
}
add_action( 'widgets_init', 'wp_travel_register_trip_type_widgets' );