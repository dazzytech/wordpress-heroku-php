<?php
/**
 * Plugin Name: WP Travel Standard PayPal
 * Plugin URI: http://wptravel.io/downloads/standard-paypal
 * Description: This plugin is addons plugin for wp-travel.
 * Version: 1.0.0
 * Author: WEN Solutions
 * Author URI: http://wensolutions.com
 * Requires at least: 4.4
 * Tested up to: 4.9
 *
 * Text Domain: wp-travel-booking
 * Domain Path: /i18n/languages/
 *
 * @package WP-Travel-Paypal
 * @category Core
 * @author WenSolutions
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_travel_paypal' ) ) :

	/**
	 * Main WP_travel_paypal Class (singleton).
	 *
	 * @since 1.0.0
	 */
	final class WP_travel_paypal {

		/**
		 * Plugin Name.
		 *
		 * @var string
		 */
		public $plugin_name = 'wp-travel-paypal';

		/**
		 * Assets Path.
		 *
		 * @var string
		 */
		public $assets_path;

		/**
		 * WP Travel Paypal version.
		 *
		 * @var string
		 */
		public $version = '1.0.0';
		/**
		 * The single instance of the class.
		 *
		 * @var WP Travel
		 * @since 1.0.0
		 */
		protected static $_instance = null;

		/**
		 * Admin Settings Page.
		 *
		 * @var string
		 */
		static $collection = 'settings';

		/**
		 * Main WP_travel_paypal Instance.
		 * Ensures only one instance of WP_travel_paypal is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 * @static
		 * @see WP_travel_paypal()
		 * @return WP_travel_paypal - Main instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * WP_Travel Constructor.
		 */
		function __construct() {
			$this->define_constants();
			$this->assets_path = plugin_dir_url( WP_TRAVEL_PAYPAL_PLUGIN_FILE ) . 'assets/';
			$this->includes();
			$this->init_hooks();
		}

		/**
		 * Define WC Constants.
		 */
		private function define_constants() {
			$this->define( 'WP_TRAVEL_PAYPAL_PLUGIN_FILE', __FILE__ );
			$this->define( 'WP_TRAVEL_PAYPAL_ABSPATH', dirname( __FILE__ ) . '/' );
			$this->define( 'WP_TRAVEL_PAYPAL_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			$this->define( 'WP_TRAVEL_PAYPAL_PLUGIN_PATH', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
			$this->define( 'WP_TRAVEL_PAYPAL_TEMPLATE_PATH', 'wp-travel/' );
			$this->define( 'WP_TRAVEL_PAYPAL_VERSION', $this->version );
			$this->define( 'WP_TRAVEL_MINIMUM_PARTIAL_PAYOUT', 10 ); // In percent.
		}

		/**
		 * Hook into actions and filters.
		 *
		 * @since 1.0.0
		 * @return void
		 */
		private function init_hooks() {
			add_action( 'init', 'wp_travel_paypal_register_post_type' );
			register_activation_hook( __FILE__, array( $this, 'wp_travel_paypal_activation' ) );

			if ( wtp_is_request( 'admin' ) ) {
				add_action( 'admin_init', array( $this, 'wp_travel_check_dependency' ) );
				// Add Payment Tab on Settings.
				add_filter( 'wp_travel_admin_tabs', 'wp_travel_payment_add_tabs', 20 );
				add_action( 'wp_travel_tabs_content_settings', 'wp_travel_payment_tab_call_back', 12, 2 );
				add_action( 'wp_travel_tabs_content_settings', 'wp_travel_debug_tab_call_back', 12, 2 );
				// Add paypal settings fields.
				add_filter( 'wp_travel_before_save_settings', 'wp_travel_payment_save_payment_settings' );

				// Add Minimum payout amount on itinerary additional info tab.
				add_action( 'wp_travel_itinerary_after_sale_price', 'wp_travel_itinerary_minimum_payout' );
				// Save minimum payout amount.
				add_action( 'wp_travel_itinerary_extra_meta_save', 'wp_travel_save_minimum_payout_amount' );

				add_filter( 'wp_travel_chart_data', 'wp_travel_payment_stat_data' );

				add_action( 'wp_travel_after_deleting_booking_transient', 'wp_travel_clear_payment_transient' );
				add_action( 'admin_notices', 'wp_travel_payment_admin_notices' );
			}
			// Add Payment fields in booking form.
			add_filter( 'wp_travel_booking_form_fields', 'wtp_booking_fields' );

			// Add Metabox for payment info.
			add_action( 'add_meta_boxes', array( $this, 'register_metaboxes' ), 10, 2 );

			// Send Payment Email to admin / Customer.
			add_action( 'wp_travel_after_successful_payment', 'wp_travel_send_payment_email' );

			add_filter( 'wp_travel_booked_message', 'wp_travel_paypal_booking_message' );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string $name  Name of constant.
		 * @param  string $value Value of constant.
		 * @return void
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @return void
		 */
		function includes() {
			include sprintf( '%s/inc/helpers.php', WP_TRAVEL_PAYPAL_ABSPATH );
			include sprintf( '%s/inc/functions.php', WP_TRAVEL_PAYPAL_ABSPATH );

			include sprintf( '%s/gateways/class-wt-gateway-paypal-request.php', WP_TRAVEL_PAYPAL_ABSPATH );
			include sprintf( '%s/gateways/paypal-functions.php', WP_TRAVEL_PAYPAL_ABSPATH );
			include sprintf( '%s/inc/class-frontend-assets.php', WP_TRAVEL_PAYPAL_ABSPATH );
			include sprintf( '%s/inc/email-template-functions.php', WP_TRAVEL_PAYPAL_ABSPATH );
			// include sprintf( '%s/inc/wtp-hooks.php', WP_TRAVEL_PAYPAL_ABSPATH );

			if ( wtp_is_request( 'admin' ) ) {
				include sprintf( '%s/inc/admin/admin-helpers.php', WP_TRAVEL_PAYPAL_ABSPATH );
				include sprintf( '%s/inc/admin/admin-functions.php', WP_TRAVEL_PAYPAL_ABSPATH );

				include sprintf( '%s/inc/admin/class-admin-assets.php', WP_TRAVEL_PAYPAL_ABSPATH );
			}
		}

		/**
		 * WP Travel Activation.
		 */
		function wp_travel_paypal_activation() {
			include sprintf( '%s/inc/update-payment-fields.php', WP_TRAVEL_PAYPAL_ABSPATH );
		}

		/**
		 * WP Travel Environment.
		 */
		function wp_travel_setup_environment() {
		}

		/**
		 * Register metabox.
		 */
		public function register_metaboxes() {
			add_meta_box( 'wp-travel-itinerary-payment-detail', __( 'Payment Detail', 'wp-travel' ), array( $this, 'wp_travel_payment_info' ), 'itinerary-booking', 'normal', 'low' );
			add_meta_box( 'wp-travel-itinerary-single-payment-detail', __( 'Payment Info', 'wp-travel' ), array( $this, 'wp_travel_single_payment_info' ), 'itinerary-booking', 'side', 'low' );
		}

		/**
		 * Payment Info Metabox info
		 *
		 * @param Object $post Current Post Object.
		 * @return void
		 */
		public function wp_travel_payment_info( $post ) {
			if ( ! $post ) {
				return;
			}
			$booking_id = $post->ID;
			$payment_id = get_post_meta( $booking_id, 'wp_travel_payment_id', true );
			$paypal_args = get_post_meta( $payment_id, '_paypal_args', true );
			echo '<pre>';
			print_r( $paypal_args );
			echo '</pre>';
		}

		/**
		 * Payment Info Metabox info
		 *
		 * @param Object $post Current Post Object.
		 * @return void
		 */
		public function wp_travel_single_payment_info( $post ) {
			if ( ! $post ) {
				return;
			}
			$booking_id = $post->ID;

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
			$status = wp_travel_get_payment_status();

			$label_key = get_post_meta( $payment_id, 'wp_travel_payment_status', true ) ? get_post_meta( $payment_id, 'wp_travel_payment_status', true ) : 'N/A';

			?>
			<table>
				<tr>
					<td><strong><?php esc_html_e( 'Status', 'wp-travel' ) ?></strong</td>
					<td>
					<select id="wp_travel_payment_status" name="wp_travel_payment_status" >
					<?php foreach ( $status as $value => $st ) : ?>
						<option value="<?php echo esc_html( $value ); ?>" <?php selected( $value, $label_key ) ?>>
							<?php echo esc_html( $status[ $value ]['text'] ); ?>
						</option>
					<?php endforeach; ?>
					</select>
					</td>

				</tr>
				<?php if ( 'paid' === $label_key ) : ?>
					<?php
					$mode = wp_travel_get_payment_mode();
					$label_key = get_post_meta( $payment_id, 'wp_travel_payment_mode' , true );

					$trip_price  = ( get_post_meta( $payment_id, 'wp_travel_trip_price' , true ) ) ? get_post_meta( $payment_id, 'wp_travel_trip_price' , true ) : 0;
					$trip_price  = number_format( $trip_price, 2, '.', '' );

					$paid_amount = ( get_post_meta( $payment_id, 'wp_travel_payment_amount' , true ) ) ? get_post_meta( $payment_id, 'wp_travel_payment_amount' , true ) : 0;
					$paid_amount = number_format( $paid_amount, 2, '.', '' );

					$due_amount  = number_format( $trip_price - $paid_amount, 2, '.', '' );
					if ( $due_amount < 0 ) {
						$due_amount = 0;
					} ?>
					<tr>
						<td><strong><?php esc_html_e( 'Payment Mode', 'wp-travel' ) ?></strong</td>
						<td><?php echo esc_html( $mode[ $label_key ]['text'] ) ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Trip Price', 'wp-travel' ) ?></strong</td>
						<td><?php echo esc_html( wp_travel_get_currency_symbol() . ' ' . $trip_price ) ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Paid Amount', 'wp-travel' ) ?></strong</td>
						<td><?php echo esc_html( wp_travel_get_currency_symbol() . ' ' . $paid_amount ) ?></td>
					</tr>
					<tr>
						<td><strong><?php esc_html_e( 'Due Amount', 'wp-travel' ) ?></strong</td>
						<td><?php echo esc_html( wp_travel_get_currency_symbol() . ' ' . $due_amount ) ?></td>
					</tr>
				<?php endif; ?>
			</table>
			<?php
		}

		/**
		 * This will uninstall this plugin if parent WP-Travel plugin not found
		 */
		function wp_travel_check_dependency() {
			$plugin = plugin_basename( __FILE__ );
			$plugin_data = get_plugin_data( __FILE__, false );

			if ( ! class_exists( 'WP_Travel' ) ) {
				if ( is_plugin_active( $plugin ) ) {
					deactivate_plugins( $plugin );
					wp_die( wp_kses_post( '<strong>' . $plugin_data['Name'] . '</strong> requires the WP Travel plugin to work. Please activate it first. <br /><br />Back to the WordPress <a href="' . esc_url( get_admin_url( null, 'plugins.php' ) ) . '">Plugins page</a>.' ) );
				}
			}
		}

	}
endif;
/**
 * Main instance of WP Travel Paypal.
 *
 * Returns the main instance of WP_travel_paypal to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return WP Travel Paypal
 */
function wp_travel_paypal() {
	return WP_travel_paypal::instance();
}

// Start WP Travel.
wp_travel_paypal();
