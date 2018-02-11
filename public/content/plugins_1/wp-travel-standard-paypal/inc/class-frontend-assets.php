<?php
class WP_Travel_Paypal_Frontend_Assets {
	var $assets_path;
	public function __construct() {
		$this->assets_path = plugin_dir_url( WP_TRAVEL_PAYPAL_PLUGIN_FILE );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
	}

	function styles() {
		

	}
	function scripts() {
		$wtp_texts = array(
			'book_now' 	 => __( 'Book Now' ),
			'book_n_pay' => __( 'Book and Pay' ),
		);

		$wtp_texts = apply_filters( 'wtp_texts', $wtp_texts );
		wp_register_script( 'wp-travel-payment-frontend-script', $this->assets_path . 'assets/js/frontend-script.js', array( 'jquery' ) );
		
		wp_localize_script( 'wp-travel-payment-frontend-script', 'wtp_texts', $wtp_texts );
		wp_enqueue_script( 'wp-travel-payment-frontend-script' );
	}
}

new WP_Travel_Paypal_Frontend_Assets();
