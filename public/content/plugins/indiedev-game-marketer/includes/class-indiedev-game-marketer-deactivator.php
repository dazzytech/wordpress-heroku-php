<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://blacklodgegames.com
 * @since      1.0.0
 *
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/includes
 * @author     BLACK LODGE GAMES, LLC <jeff@blacklodgegames.com>
 */
class Indiedev_Game_Marketer_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate($networkactivation) {
            global $wpdb, $idgm_flush_rules;
            
            if (function_exists('is_multisite') && is_multisite()) {

                if ($networkactivation) {
                    $old_blog = $wpdb->blogid;

                    $blogs = get_sites();
                    foreach ( $blogs as $blog ) {
                        switch_to_blog( $blog->blog_id );
                        Indiedev_Game_Marketer_Deactivator::deleteDb();
                        restore_current_blog();
                    } 
                } else {
                    Indiedev_Game_Marketer_Deactivator::deleteDb();
                }
            } else {
                Indiedev_Game_Marketer_Deactivator::deleteDb();
            }
            
            $idgm_flush_rules = true;
	}
        
        public static function deleteDb() {
            global $wpdb;
            
        }

}
