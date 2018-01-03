<?php
/**
 * Itinerary Template : WP Travel
 *
 * @see         http://docs.wensolutions.com/document/template-structure/
 * @author      WenSolutions
 * @package     Travel_Log
 * @since       1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


$enable_sale    = get_post_meta( get_the_ID(), 'wp_travel_enable_sale', true );
$trip_price     = wp_travel_get_trip_price( get_the_ID() );
$sale_price     = wp_travel_get_trip_sale_price( get_the_ID() );
$trip_duration = get_post_meta( get_the_ID(), 'wp_travel_trip_duration', true ); 
$settings = wp_traval_get_settings();
$currency_code = ( isset( $settings['currency'] ) ) ? $settings['currency'] :'';
$currency_symbol = wp_traval_get_currency_symbol( $currency_code );?>

<div class="post-item-wrapper trip-details">
		<a href="<?php the_permalink(); ?>">
			<div class="post-thumb">
				<?php
				if ( has_post_thumbnail() ) :

					the_post_thumbnail( apply_filters( 'travel_log_trip_content_thumbnail_size', 'medium' ) );

				else :

					travel_log_no_slider_thumbnail();

				endif; ?>
			</div>
			<span class="effect"></span>
			<div class="post-content">
				<div class="trip-metas">
					<div class="clearfix title-price-wrapper" >
						<h4 class="post-title"><?php the_title(); ?></h4>
						<span class="trip-price">						
							<span class="current-price">
							<?php if ( $sale_price ) : ?>
								<del>
							<?php endif; ?>
							<?php printf( '%1s %2s',esc_html( $currency_symbol ), esc_html( $trip_price ) ); ?>
							<?php if ( $sale_price ) : ?>
								</del>
							<?php endif; ?>
							</span>
							<?php if ( $sale_price ) : ?>
								<span class="sale-price"><?php printf( '%1s %2s',esc_html( $currency_symbol ), esc_html( $sale_price ) ); ?></span>
							<?php endif; ?>
						</span>
					</div>
					<?php wp_travel_get_trip_duration( get_the_ID() ); ?>
					<div class="clearfix" >
						<?php $average_rating = wp_travel_get_average_rating(); ?>
						
						<div class="wp-travel-average-review" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'travel-log' ), $average_rating ); ?>">
							<span style="width:<?php echo esc_attr( ( $average_rating / 5 ) * 100 ); ?>%">
								<strong itemprop="ratingValue" class="rating"><?php echo esc_html( $average_rating ); ?></strong> <?php printf( esc_html__( 'out of %1$s5%2$s', 'travel-log' ), '<span itemprop="bestRating">', '</span>' ); ?>
							</span>
						</div>
						<span class="rating-count"><?php printf( '( %s Reviews )',wp_travel_get_rating_count() ); ?></span>
						
						<?php $terms = get_the_terms( get_the_ID(), 'itinerary_types' ); ?>
						<?php if ( is_array( $terms ) && count( $terms ) > 0 ) :
							$first_term = array_shift( $terms );
							$term_name = $first_term->name; ?>
							<span class="trip-category"><?php echo esc_html( $term_name ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php if ( $enable_sale ) : ?>
			<div class="wp-travel-offer">
				<span><?php esc_html_e( 'Offer', 'travel-log' ); ?></span>
			</div>
			<?php endif; ?>
	</a>
</div>