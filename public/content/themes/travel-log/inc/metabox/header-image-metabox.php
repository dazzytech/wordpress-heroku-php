<?php
/**
 * Header Image metabox file.
 *
 * @package Travel_Log
 * @since Travel_Log 1.0.7
 */

if ( ! function_exists( 'travel_log_header_image_callback' ) ) :
	/**
	 * Outputs the content of the header image option
	 */
	function travel_log_header_image_callback( $post ) {

		wp_nonce_field( basename( __FILE__ ), 'travel_log_nonce' );

		$stored_header_image_option = get_post_meta( $post->ID, 'travel-log-header-image-status', true );

		?>

			<p>
				<input id="chk_title" type="checkbox" value="1" name="travel-log-header-image-meta" <?php if ( isset( $stored_header_image_option ) ) { checked( $stored_header_image_option, true ); }?>>
				
				<label for="chk_title" class="travel-log-row-title"><?php esc_html_e( 'Check to use featured image as banner image', 'travel-log' )?></label>
			
			</p>
		
		<?php
	}

endif;

if ( ! function_exists( 'travel_log_header_image_save' ) ) :
	/**
	 * Saves the header option
	 */
	function travel_log_header_image_save( $post_id ) {

		// Checks save status.
		$is_autosave = wp_is_post_autosave( $post_id );
		$is_revision = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST['travel_log_nonce'] ) && wp_verify_nonce( sanitize_key( $_POST['travel_log_nonce'] ), basename( __FILE__ ) ) ) ? 'true' : 'false';

		// Exits script depending on save status.
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}

		// Checks for input and sanitizes/saves if needed.
		if ( isset( $_POST['travel-log-header-image-meta'] ) ) {

			update_post_meta( $post_id, 'travel-log-header-image-status', wp_unslash( $_POST['travel-log-header-image-meta'] ) );
		} else {

			delete_post_meta( $post_id, 'travel-log-header-image-status' );
		}

	}
endif;
add_action( 'save_post', 'travel_log_header_image_save' );
