<?php

/**
 * Fired during plugin activation
 *
 * @link       http://blacklodgegames.com
 * @since      1.0.0
 *
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/includes
 * @author     BLACK LODGE GAMES, LLC <jeff@blacklodgegames.com>
 */
class Indiedev_Game_Marketer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate($networkwide) {
            global $wpdb, $idgm_flush_rules, $Indiedev_Game_Marketer_dbVersion;
            
            Indiedev_Game_Marketer_Activator::upgrade($networkwide); // Check for upgrades
            
            add_option( 'idgm_db_version', $Indiedev_Game_Marketer_dbVersion );            
            
            if (function_exists('is_multisite') && is_multisite()) {

                if ($networkwide) {
                    if ( false == is_super_admin() ) {
                        return;
                    }
                    $blogs = get_sites();
                    foreach ( $blogs as $blog ) {
                        switch_to_blog( $blog->blog_id );
                        Indiedev_Game_Marketer_Activator::createDb();
                        restore_current_blog();
                    }
                    $idgm_flush_rules = true;
                } else {
                    if ( false == current_user_can( 'activate_plugins' ) ) {
                        return;
                    }
                    Indiedev_Game_Marketer_Activator::createDb();
                    $idgm_flush_rules = true;
                } 
            } else {
                Indiedev_Game_Marketer_Activator::createDb();
                $idgm_flush_rules = true;
            }
            
            

        }

        public static function createDb() {
            global $wpdb;

            $charset_collate = $wpdb->get_charset_collate();

            $table_name = $wpdb->prefix . "idgm_games";
            
            $sql = "CREATE TABLE {$table_name} (
              id mediumint(9) NOT NULL AUTO_INCREMENT,
              name tinytext NOT NULL,              
              logo varchar(254) DEFAULT '' NOT NULL,                             
              icon varchar(254) DEFAULT '' NOT NULL,  
              small_desc text NOT NULL,
              long_desc text NOT NULL,              
              genres varchar(254) DEFAULT '' NOT NULL, 
              multiplayer varchar(254) DEFAULT '' NOT NULL, 
              home_url varchar(254) DEFAULT '' NOT NULL,              
              developers varchar(254) DEFAULT '' NOT NULL,
              publishers varchar(254) DEFAULT '' NOT NULL,
              distributors varchar(254) DEFAULT '' NOT NULL,              
              producers varchar(254) DEFAULT '' NOT NULL,              
              designers varchar(254) DEFAULT '' NOT NULL,              
              programmers varchar(254) DEFAULT '' NOT NULL,               
              artists varchar(254) DEFAULT '' NOT NULL, 
              writers varchar(254) DEFAULT '' NOT NULL,               
              composers varchar(254) DEFAULT '' NOT NULL,               
              game_engine varchar(254) DEFAULT '' NOT NULL,   
              franchise_series varchar(254) DEFAULT '' NOT NULL, 
              platform_a varchar(254) DEFAULT '' NOT NULL,
              release_date_a date DEFAULT '0000-00-00' NOT NULL,
              platform_b varchar(254) DEFAULT '' NOT NULL,
              release_date_b date DEFAULT '0000-00-00' NOT NULL,              
              platform_c varchar(254) DEFAULT '' NOT NULL,
              release_date_c date DEFAULT '0000-00-00' NOT NULL,              
              platform_d varchar(254) DEFAULT '' NOT NULL,
              release_date_d date DEFAULT '0000-00-00' NOT NULL,              
              platform_e varchar(254) DEFAULT '' NOT NULL,
              release_date_e date DEFAULT '0000-00-00' NOT NULL,              
              platform_f varchar(254) DEFAULT '' NOT NULL,
              release_date_f date DEFAULT '0000-00-00' NOT NULL,              
              platform_g varchar(254) DEFAULT '' NOT NULL,
              release_date_g date DEFAULT '0000-00-00' NOT NULL,              
              platform_h varchar(254) DEFAULT '' NOT NULL,
              release_date_h date DEFAULT '0000-00-00' NOT NULL,              
              platform_i varchar(254) DEFAULT '' NOT NULL,
              release_date_i date DEFAULT '0000-00-00' NOT NULL,              
              platform_j varchar(254) DEFAULT '' NOT NULL,
              release_date_j date DEFAULT '0000-00-00' NOT NULL,   
              page mediumint(9) NOT NULL,
              price varchar(254) DEFAULT '' NOT NULL,
              greenlight_url varchar(254) DEFAULT '' NOT NULL,  
              release_a_url varchar(254) DEFAULT '' NOT NULL,  
              release_b_url varchar(254) DEFAULT '' NOT NULL,  
              release_c_url varchar(254) DEFAULT '' NOT NULL,  
              release_d_url varchar(254) DEFAULT '' NOT NULL,  
              release_e_url varchar(254) DEFAULT '' NOT NULL,  
              release_f_url varchar(254) DEFAULT '' NOT NULL,  
              release_g_url varchar(254) DEFAULT '' NOT NULL,  
              release_h_url varchar(254) DEFAULT '' NOT NULL,  
              release_i_url varchar(254) DEFAULT '' NOT NULL,  
              release_j_url varchar(254) DEFAULT '' NOT NULL,  
              PRIMARY KEY  (id)
            ) {$charset_collate};";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );       
            
            $table_name = $wpdb->prefix . "idgm_tweets";
            
            $sql = "CREATE TABLE {$table_name} (
                id int(11) NOT NULL AUTO_INCREMENT,
                post varchar(255) NOT NULL,
                image1 varchar(255) NOT NULL,
                image2 varchar(255) NOT NULL,
                image3 varchar(255) NOT NULL,
                image4 varchar(255) NOT NULL,
                post_frequency varchar(25) NOT NULL,
                post_date_time varchar(255) NOT NULL,
                auto_attach varchar(255) NOT NULL,
                status varchar(255) NOT NULL,
                PRIMARY KEY (id)
            ) {$charset_collate};";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );            
            
        }
        
        public static function upgradeDb() {
            global $wpdb;
            $row = $wpdb->get_results(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '{$wpdb->prefix}idgm_games' AND column_name = 'release_a_url'"  );

            if(empty($row)){
               $wpdb->query("ALTER TABLE '{$wpdb->prefix}idgm_games' ADD release_a_url varchar(254) DEFAULT '' NOT NULL, release_b_url varchar(254) DEFAULT '' NOT NULL, release_c_url varchar(254) DEFAULT '' NOT NULL, release_d_url varchar(254) DEFAULT '' NOT NULL, release_e_url varchar(254) DEFAULT '' NOT NULL, release_f_url varchar(254) DEFAULT '' NOT NULL, release_g_url varchar(254) DEFAULT '' NOT NULL, release_h_url varchar(254) DEFAULT '' NOT NULL, release_i_url varchar(254) DEFAULT '' NOT NULL, release_j_url varchar(254) DEFAULT '' NOT NULL;");
            }              
        }
        
        public static function upgrade($networkwide) {
            global $Indiedev_Game_Marketer_dbVersion;
            $installed_db_version = get_option( 'idgm_db_version' );
            if ($installed_db_version !== false) {
                if ($installed_db_version != $Indiedev_Game_Marketer_dbVersion) { // Perform an upgrade
                    // Upgrade code goes here
                    
                    if (function_exists('is_multisite') && is_multisite()) {

                        if ($networkwide) {
                            if ( false == is_super_admin() ) {
                                return;
                            }
                            $blogs = get_sites();
                            foreach ( $blogs as $blog ) {
                                switch_to_blog( $blog->blog_id );
                                Indiedev_Game_Marketer_Activator::upgradeDb();
                                restore_current_blog();
                            }
                            $idgm_flush_rules = true;
                        } else {
                            if ( false == current_user_can( 'activate_plugins' ) ) {
                                return;
                            }
                            Indiedev_Game_Marketer_Activator::upgradeDb();
                            $idgm_flush_rules = true;
                        } 
                    } else {
                        Indiedev_Game_Marketer_Activator::upgradeDb();
                        $idgm_flush_rules = true;
                    }                    
                                      
                }
            }
        }
        
}
