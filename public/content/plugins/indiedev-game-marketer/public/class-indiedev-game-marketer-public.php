<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://blacklodgegames.com
 * @since      1.0.0
 *
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/public
 * @author     BLACK LODGE GAMES, LLC <jeff@blacklodgegames.com>
 */
class Indiedev_Game_Marketer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Indiedev_Game_Marketer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Indiedev_Game_Marketer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                if ($options['Indiedev_Game_Marketer_select_css'] != 'off') {
                    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/indiedev-game-marketer-public.css', array(), $this->version, 'all' );
                }
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Indiedev_Game_Marketer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Indiedev_Game_Marketer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/indiedev-game-marketer-public.js', array( 'jquery' ), $this->version, false );

	}

        /**
         * 
         */
        public function Indiedev_Game_Marketer_promo_posttype() {

            // create a new taxonomy
            register_taxonomy(
                    'game_promo',
                    'promo_materials',
                    array(
                            'labels' => array(
                              'name' => _x( 'Game Promo Types', 'taxonomy general name', 'indiedev-game-marketer' ),
                              'singular_name' => _x( 'Game Promo Type', 'taxonomy singular name', 'indiedev-game-marketer' ),
                              'search_items' =>  __( 'Search Game Promos', 'indiedev-game-marketer' ),
                              'all_items' => __( 'All Game Promos', 'indiedev-game-marketer' ),
                              'edit_item' => __( 'Edit Game Promo Type', 'indiedev-game-marketer' ),
                              'update_item' => __( 'Update Game Promo Type', 'indiedev-game-marketer' ),
                              'add_new_item' => __( 'Add New Game Promo Type', 'indiedev-game-marketer' ),
                              'new_item_name' => __( 'New Game Promo Type Name', 'indiedev-game-marketer' ),
                              'menu_name' => __( 'Game Promo Types' ),
                            ),                        
                            'rewrite' => array( 'slug' => 'game-info-type' ),
                            'hierarchical' => true,
                            'capabilities' => array(
                                    'assign_terms' => 'edit_posts',
                                    'edit_terms' => 'manage_categories'
                            )
                    )
            );            
            
            register_post_type( 'promo_materials',
                    array(
                            'labels' => array(
                                    'name'                => __( 'Promo Materials', 'indiedev-game-marketer' ),
                                    'singular_name'       => __( 'Promo Materials', 'indiedev-game-marketer' ),
                                    'menu_name'           => __( 'Promo Materials', 'indiedev-game-marketer' ),
                                    'all_items'           => __( 'All Promo Materials', 'indiedev-game-marketer' ),
                                    'view_item'           => __( 'View Promo', 'indiedev-game-marketer' ),
                                    'add_new_item'        => __( 'Add New Game Promo', 'indiedev-game-marketer' ),
                                    'add_new'             => __( 'Add New', 'indiedev-game-marketer' ),
                                    'edit_item'           => __( 'Edit Promo', 'indiedev-game-marketer' ),
                                    'update_item'         => __( 'Update Promo', 'indiedev-game-marketer' ),
                                    'search_items'        => __( 'Search Promo', 'indiedev-game-marketer' ),
                                    'not_found'           => __( 'Not Found', 'indiedev-game-marketer' ),
                                    'not_found_in_trash'  => __( 'Not found in Trash', 'indiedev-game-marketer' )                                
                            ),
                            'public' => true,
                            'has_archive' => false,
                            'rewrite' => array('slug' => 'game-info'),
                            'menu_position' => '',
                            'show_in_menu' => 'indiedev-game-marketer',
                            'hierarchical' => false,
                            'exclude_from_search' => true,
                            'taxonomies'  => array( 'game_promo' ),
                            'capability_type' => 'post',
                            'show_in_admin_bar'   => true,
                            'show_in_nav_menus'   => false,
                            'publicly_queryable'  => false,
                            'query_var'           => false
                    )
            );
            
            register_taxonomy_for_object_type('game_promo', 'promo_materials');
            
            if (!term_exists(__( 'Screenshots', 'indiedev-game-marketer' ), 'game_promo' )) {
                wp_insert_term(
                  __( 'Screenshots', 'indiedev-game-marketer' ), // the term 
                  'game_promo', // the taxonomy
                  array(
                    'description'=> __( 'Screenshots of the game.', 'indiedev-game-marketer' ),
                    'slug' => 'game-screenshots'
                  )
                );
            }
            
            if (!term_exists(__( 'Videos', 'indiedev-game-marketer' ), 'game_promo' )) {
                wp_insert_term(
                  __( 'Videos', 'indiedev-game-marketer' ), // the term 
                  'game_promo', // the taxonomy
                  array(
                    'description'=> __( 'Videos of the game.', 'indiedev-game-marketer' ),
                    'slug' => 'game-videos'
                  )
                );    
            }
            
            if (!term_exists(__( 'Press Coverage', 'indiedev-game-marketer' ), 'game_promo' )) {
                wp_insert_term(
                  __( 'Press Coverage', 'indiedev-game-marketer' ), // the term 
                  'game_promo', // the taxonomy
                  array(
                    'description'=> __( 'Videos of the game.', 'indiedev-game-marketer' ),
                    'slug' => 'game-press-coverage'
                  )
                );            
            }
            
            if (!term_exists(__( 'Awards', 'indiedev-game-marketer' ), 'game_promo' )) {
                wp_insert_term(
                  __( 'Awards', 'indiedev-game-marketer' ), // the term 
                  'game_promo', // the taxonomy
                  array(
                    'description'=> __( 'Awards the game won.', 'indiedev-game-marketer' ),
                    'slug' => 'game-awards'
                  )
                ); 
            } 
            
            register_post_type( 'press_releases',
                    array(
                            'labels' => array(
                                    'name'                => __( 'Press Releases', 'indiedev-game-marketer' ),
                                    'singular_name'       => __( 'Press Release', 'indiedev-game-marketer' ),
                                    'menu_name'           => __( 'Press Releases', 'indiedev-game-marketer' ),
                                    'all_items'           => __( 'All Press Releases', 'indiedev-game-marketer' ),
                                    'view_item'           => __( 'View Press Release', 'indiedev-game-marketer' ),
                                    'add_new_item'        => __( 'Add New Press Release', 'indiedev-game-marketer' ),
                                    'add_new'             => __( 'Add New', 'indiedev-game-marketer' ),
                                    'edit_item'           => __( 'Edit Press Release', 'indiedev-game-marketer' ),
                                    'update_item'         => __( 'Update Press Release', 'indiedev-game-marketer' ),
                                    'search_items'        => __( 'Search Press Releases', 'indiedev-game-marketer' ),
                                    'not_found'           => __( 'Not Found', 'indiedev-game-marketer' ),
                                    'not_found_in_trash'  => __( 'Not found in Trash', 'indiedev-game-marketer' )                                
                            ),
                            'public' => true,
                            'has_archive' => true,
                            'rewrite' => array('slug' => 'press-release'),
                            'menu_position' => '',
                            'show_in_menu' => 'indiedev-game-marketer',
                            'hierarchical' => false,
                            'exclude_from_search' => false,
                            'capability_type' => 'post',
                            'show_in_admin_bar'   => true,
                            'show_in_nav_menus'   => true,
                            'publicly_queryable'  => true,
                            'query_var'           => true
                    )
            );            
            
            
        }
        
        /**
         * Does the hard work for displaying stuff in the right format
         * 
         * @param type $option
         * @param type $style
         * @param type $labels
         */
        public function prepare_option_for_display($option, $style, $labels) {
            $returned_string_var = '';
            $temp_string_var = '';
            
            $indiedev_options = get_option( 'Indiedev_Game_Marketer_settings' );
            
            if (trim($indiedev_options[$option]) != '' && $option != 'Indiedev_Game_Marketer_select_company_business_activity_secondary') {
            
                if (strtolower($style) == 'ul' ) {
                    $returned_string_var .= '<ul class="indiedev-list">';
                }
                
            //$options = get_option( 'Indiedev_Game_Marketer_settings' );
            //$options['Indiedev_Game_Marketer_text_company_location']                
                if (strtolower($labels) == 'true' ) {
                    switch ($option) {
                        case 'Indiedev_Game_Marketer_text_company_name' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Name', 'indiedev-game-marketer' ). ':</strong> '; 
                            break;
                        case 'Indiedev_Game_Marketer_text_company_desc' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Description', 'indiedev-game-marketer' ). ':</strong> '; 
                            break;     
                        case 'Indiedev_Game_Marketer_text_company_location' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Location', 'indiedev-game-marketer' ). ':</strong> '; 
                            break;                          
                        case 'Indiedev_Game_Marketer_select_company_business_activity_main' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Industry Role', 'indiedev-game-marketer' ). ':</strong> ';
                            break;                       
                        case 'Indiedev_Game_Marketer_textarea_company_main_press_email' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Press Contact', 'indiedev-game-marketer' ). ':</strong> ';
                            break;                            
                        case 'Indiedev_Game_Marketer_text_company_website' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Website', 'indiedev-game-marketer' ). ':</strong> ';
                            break;                            
                        case 'Indiedev_Game_Marketer_text_company_facebook' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Facebook', 'indiedev-game-marketer' ). ':</strong> ';
                            break;                            
                        case 'Indiedev_Game_Marketer_text_company_twitter' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Twitter', 'indiedev-game-marketer' ). ':</strong> ';
                            break;                            
                        case 'Indiedev_Game_Marketer_text_company_youtube' :
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'YouTube', 'indiedev-game-marketer' ). ':</strong> ';
                            break;                            
                        case 'Indiedev_Game_Marketer_text_company_pr_phone' :                 
                            $temp_string_var = '<strong class="indiedev-label">'.__( 'Phone', 'indiedev-game-marketer' ). ':</strong> ';
                            break;                            
                        default :

                    }
                    if (strtolower($style) == 'ul' || strtolower($style) == 'li' ) {
                        $returned_string_var .= '<li class="indiedev-list-item">';
                    }
                    $returned_string_var .= $temp_string_var;
                } 

                switch ($option) {                     
                    case 'Indiedev_Game_Marketer_textarea_company_main_press_email' :
                       $returned_string_var .= '<a href="mailto:'.$indiedev_options[$option].'" class="indiedev-link">';
                        break;                            
                    case 'Indiedev_Game_Marketer_text_company_website' :
                        $returned_string_var .= '<a href="'.$this->fix_link($indiedev_options[$option]).'" class="indiedev-link">';
                        break;                                     
                    case 'Indiedev_Game_Marketer_text_company_facebook' :
                        $returned_string_var .= '<a href="'.$this->fix_facebook_link($indiedev_options[$option]).'" class="indiedev-link">';
                        break;                            
                    case 'Indiedev_Game_Marketer_text_company_twitter' :
                        $returned_string_var .= '<a href="http://twitter.com/'.$this->fix_twitter_link($indiedev_options[$option]).'" class="indiedev-link">@';
                        break;                            
                    case 'Indiedev_Game_Marketer_text_company_youtube' :
                        $returned_string_var .= '<a href="'.$this->fix_link($indiedev_options[$option]).'" class="indiedev-link">';
                        break;                                                      
                    default :

                }                
                
                $returned_string_var .= $indiedev_options[$option];

                switch ($option) {                     
                    case 'Indiedev_Game_Marketer_textarea_company_main_press_email' :
                       $returned_string_var .= '</a>';
                        break;                            
                    case 'Indiedev_Game_Marketer_text_company_website' :
                        $returned_string_var .= '</a>';
                        break;                            
                    case 'Indiedev_Game_Marketer_text_company_facebook' :
                        $returned_string_var .= '</a>';
                        break;                            
                    case 'Indiedev_Game_Marketer_text_company_twitter' :
                        $returned_string_var .= '</a>';
                        break;                            
                    case 'Indiedev_Game_Marketer_text_company_youtube' :
                        $returned_string_var .= '</a>';
                        break;                                                      
                    default :

                }                  

                if ($option == 'Indiedev_Game_Marketer_select_company_business_activity_main' && trim($indiedev_options['Indiedev_Game_Marketer_select_company_business_activity_secondary']) != '') {
                    $returned_string_var .= ' & '. $indiedev_options['Indiedev_Game_Marketer_select_company_business_activity_secondary'];
                }
                
                if (strtolower($style) == 'ul' || strtolower($style) == 'li' ) {
                    $returned_string_var .= '</li>';
                } else {
                    if (strtolower($style) != 'inline') {
                        $returned_string_var .= '<br />';
                    }
                }           

                if (strtolower($style) == 'ul' ) {
                    $returned_string_var .= '</ul>';
                }
            
            }
               
            return $returned_string_var;
            
        }
        
        
        public function prepare_game_for_display($game_id_raw, $display, $style, $labels, $tag) {
            $returned_string_var = '';
            $temp_string_var = '';
            
            $game_id = intval($game_id_raw);
            if ($display=='game') {
                $game = $this->get_game($game_id);
            } else {
                if($display=='presskit') {
                    
                } else {
                    if ($display == 'name' || $display == 'logo' || $display == 'icon' || $display == 'small_desc' || $display == 'long_desc' || $display == 'genres' || $display == 'multiplayer' || $display == 'home_url' || $display == 'developers' || $display == 'publishers' || $display == 'distributors' || $display == 'producers' || $display == 'designers' || $display == 'programmers' || $display == 'artists' || $display == 'writers' || $display == 'composers' || $display == 'game_engine' || $display == 'franchise_series' || $display == 'platform_a' || $display == 'release_date_a' || $display == 'platform_b' || $display == 'release_date_b' || $display == 'platform_c' || $display == 'release_date_c' || $display == 'platform_d' || $display == 'release_date_d' || $display == 'platform_e' || $display == 'release_date_e' || $display == 'platform_f' || $display == 'release_date_f' || $display == 'platform_g' || $display == 'release_date_g' || $display == 'platform_h' || $display == 'release_date_h' || $display == 'platform_i' || $display == 'release_date_i' || $display == 'platform_j' || $display == 'release_date_j' || $display == 'page' || $display == 'greenlight_url') {
                        $game = $this->get_game($game_id, esc_sql('`'.$display.'`'));
                    }
                }
            }
            
            if($game===null) {
                // FAILURE
            } else {
                //if ($display=='game') {
                    if (strtolower($style) == 'ul' ) {
                        $returned_string_var .= '<ul class="indiedev-list">';
                    }
                    foreach($game as $current_game_item) {
                        if (strtolower($style) == 'ul' || strtolower($style) == 'li' ) {
                            $returned_string_var .= '<li class="indiedev-list-item">';
                        }                        
                        
                        if ($display == 'page') {
                            $game_name = $this->get_game($game_id, esc_sql('`name`, `page`'));
                            $game_presskit_publish_status = get_post_status($game_name['page']);
                            if ($game_presskit_publish_status != false && $game_presskit_publish_status == 'publish') {
                                $returned_string_var .= '<a href="'.get_permalink($current_game_item).'">'.sprintf( esc_html( '%s Presskit', 'indiedev-game-marketer' ), $game_name['name'] ).'</a>';
                            } else {
                                $returned_string_var .= sprintf( esc_html( 'The %s Presskit is not ready at this time.', 'indiedev-game-marketer' ), $game_name['name'] );
                            }
                        } elseif ($display == 'home_url') {
                            $game_name = $this->get_game($game_id, esc_sql('`name`, `home_url`'));
                            $returned_string_var .= '<a href="'.$this->fix_link($current_game_item).'">'. esc_html($game_name['name']) .'</a>';      
                        } elseif ($display == 'greenlight_url') {
                            $returned_string_var .= '<a href="'.get_home_url().'/index.php?greenlight='.$game_id.'">'.$the_game['greenlight_url'].'</a>';
                        } elseif ($display == 'icon' || $display == 'logo') {
                            $game_name = $this->get_game($game_id, esc_sql('`name`'));
                            $returned_string_var .= '<img src="'.$current_game_item.'" alt="'. esc_html($game_name['name']) .'" />';
                        } else {
                            $returned_string_var .= $current_game_item;
                        }
                        
                        if (strtolower($style) == 'ul' || strtolower($style) == 'li' ) {
                            $returned_string_var .= '</li">';
                        } else {
                            if (strtolower($style) != 'inline') {
                                $returned_string_var .= '<br />';
                            }                            
                        }
                    }
                    if (strtolower($style) == 'ul' ) {
                        $returned_string_var .= '</ul>';
                    }                    
                //} else {
                    
                //}
            }


            return $returned_string_var;
            
        }
        
        public function fix_link($link_or_zelda_to_fix) {
            $fixed = strtolower($link_or_zelda_to_fix);
            if (strpos($link_or_zelda_to_fix, 'http://') === false && strpos($link_or_zelda_to_fix, 'https://') === false) {
                $fixed = 'http://'.$link_or_zelda_to_fix;
            }
            return $fixed;
        }
        
        public function fix_twitter_link($link_or_zelda_to_fix) {
            $fixed = strtolower($link_or_zelda_to_fix);
            if (strpos($link_or_zelda_to_fix, 'https://twitter.com/') !== false || strpos($link_or_zelda_to_fix, 'http://twitter.com/') !== false || strpos($link_or_zelda_to_fix, 'https://www.twitter.com/') !== false || strpos($link_or_zelda_to_fix, 'http://www.twitter.com/') !== false) {
                $fixed = str_replace('https://twitter.com/', '', $fixed);
                $fixed = str_replace('http://twitter.com/', '', $fixed);
                $fixed = str_replace('https://www.twitter.com/', '', $fixed);
                $fixed = str_replace('http://www.twitter.com/', '', $fixed);
            }
            return $fixed;
        }      
        
        public function fix_facebook_link($link_or_zelda_to_fix) {
            $fixed = strtolower($link_or_zelda_to_fix);
            if (strpos($link_or_zelda_to_fix, 'https://www.facebook.com/') === false && strpos($link_or_zelda_to_fix, 'http://www.facebook.com/') === false && strpos($link_or_zelda_to_fix, 'https://facebook.com/') === false && strpos($link_or_zelda_to_fix, 'http://facebook.com/') === false) {
                $fixed = 'https://www.facebook.com/'.$link_or_zelda_to_fix;
            }
            return $fixed;
        }              
        
        public function game_platform_url($platform_name, $platform_url) {
           $string = '';
           if ($platform_url !== null && trim($platform_url) !== '') {
               $string = '<a href="'.$this->fix_link($platform_url).'">'.$platform_name.'</a>';
           } else {
               $string = $platform_name;
           }
           return $string;
        }
        
        public function idgm_display_presskit($game_id) {
            global $wpdb;
            
            $the_game = $this->get_game(intval($game_id));
            $indiedev_options = get_option( 'Indiedev_Game_Marketer_settings' );
            $contents_return_value = '<div class="indiedev-presskit-wrap"><div class="indiedev-presskit-content"><div class="indiedev-presskit-top">';

            $contents_return_value .= '<div class="indiedev-presskit-toc indiedev-presskit-entry">';
            $contents_return_value .= '<h3 class="indiedev-h3">'.__('Contents', 'indiedev-game-marketer').'</h3>';
            $contents_return_value .= '<ul class="indiedev-list">';
            $contents_return_value .= '     <li class="indiedev-list-item"><a href="#indiedev-factsheet" class="indiedev-link">'.__('Factsheet', 'indiedev-game-marketer').'</a></li>';
            $contents_return_value .= '     <li class="indiedev-list-item"><a href="#indiedev-desc" class="indiedev-link">'.__('Description', 'indiedev-game-marketer').'</a></li>';
            
            $return_value .= '<a name="indiedev-factsheet"></a><div class="indiedev-presskit-factsheet indiedev-presskit-entry">';
            $return_value .= '<h3 class="indiedev-h3">'.__('Factsheet', 'indiedev-game-marketer').'</h3>';
            $return_value .= '<ul class="indiedev-list">';
            
            if (trim($the_game['developers']) != '') {
                $return_value .= '  <li class="indiedev-list-item"><strong>'.__('Developer', 'indiedev-game-marketer').':</strong> '.$the_game['developers'].'</li>';
            }
            
            if (trim($the_game['publishers']) != '') {
                $return_value .= '  <li class="indiedev-list-item"><strong>'.__('Publisher', 'indiedev-game-marketer').':</strong> '.$the_game['publishers'].'</li>';
            }
            
            if (trim($the_game['home_url']) != '') {
                $return_value .= '  <li class="indiedev-list-item"><strong>'.__('Official Website', 'indiedev-game-marketer').':</strong> <a href="'.$this->fix_link($the_game['home_url']).'">'.$the_game['home_url'].'</a></li>';
            }            
            
            if (trim($the_game['greenlight_url']) != '') {
                $return_value .= '  <li class="indiedev-list-item"><strong>'.__('Steam Greenlight', 'indiedev-game-marketer').':</strong> <a href="'.get_home_url().'/index.php?greenlight='.$game_id.'">'.$the_game['greenlight_url'].'</a></li>';
            }               
            
            if (trim($the_game['release_date_a']) != '0000-00-00') {
                $return_value .= '  <li class="indiedev-list-item"><strong>'.__('Initial release date', 'indiedev-game-marketer').':</strong> '.$the_game['release_date_a'].'</li>';
            }
            
            if (trim($the_game['platform_a']) != '') {
                $return_value .= '  <li class="indiedev-list-item"><strong>'.__('Platforms', 'indiedev-game-marketer').':</strong> ' . $this->game_platform_url($the_game['platform_a'], $the_game['release_a_url']);
                if (trim($the_game['platform_b']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_b'], $the_game['release_b_url']); }
                if (trim($the_game['platform_c']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_c'], $the_game['release_c_url']); }
                if (trim($the_game['platform_d']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_d'], $the_game['release_d_url']); }
                if (trim($the_game['platform_e']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_e'], $the_game['release_e_url']); }
                if (trim($the_game['platform_f']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_f'], $the_game['release_f_url']); }
                if (trim($the_game['platform_g']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_g'], $the_game['release_g_url']); }
                if (trim($the_game['platform_h']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_h'], $the_game['release_h_url']); }
                if (trim($the_game['platform_i']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_i'], $the_game['release_i_url']); }
                if (trim($the_game['platform_j']) != '') { $return_value .= ', ' . $this->game_platform_url($the_game['platform_j'], $the_game['release_j_url']); }
                $return_value .= '  </li>';
            }    
            
            if (trim($the_game['price']) != '') {
                $return_value .= '  <li class="indiedev-list-item"><strong>'.__('Regular price', 'indiedev-game-marketer').':</strong> '.$the_game['price'].'</li>';
            }            
            
            if (trim($the_game['game_engine']) != '') {
                $return_value .= '  <li class="indiedev-list-item"><strong>'.__('Game Engine', 'indiedev-game-marketer').':</strong> '.$the_game['game_engine'].'</li>';
            }            
            
            $return_value .= '</ul>';
            $return_value .= '</div></div><br />';
            
            $return_value .= '<a name="indiedev-desc"></a><div class="indiedev-presskit-description indiedev-presskit-entry">';
            $return_value .= '<h3 class="indiedev-h3">'.__('Description', 'indiedev-game-marketer').'</h3>';            
            $return_value .= "<p>" . stripslashes($the_game['small_desc']) . "</p><p>" . stripslashes($the_game['long_desc']) ."</p>";
            $return_value .= '</div><br />';
            
            $term_args=array(
                'hide_empty' => true,
                'orderby' => 'name',
                'order' => 'DESC'
              );
            
            $game_promo_terms = get_terms( 'game_promo', $term_args );
            
            foreach ( $game_promo_terms as $game_promo_term ) { 
                $the_query = new WP_Query( array(
                    'meta_key' => 'idgm_promo_game_choice', 
                    'meta_value' => "{$game_id}",
                    'post_type' => 'promo_materials',                            
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'game_promo',
                            'field' => 'slug',
                            'terms' => array( $game_promo_term->slug ),
                            'operator' => 'IN'
                        )                            
                    )
                ) );
                                   
                if ($the_query->have_posts()) {
                    $return_value .= '<a name="indiedev-presskit-item-'.$game_promo_term->slug.'"></a><div class="indiedev-presskit indiedev-presskit-entry">';
                    $return_value .= '<h3 class="indiedev-h3">'.$game_promo_term->name.'</h3>';
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        $contents_return_value .= '     <li><a href="#indiedev-presskit-item-'.$game_promo_term->slug.'" class="indiedev-link">'.$game_promo_term->name.'</a></li>';
                        $return_value .= '<h6 class="indiedev-h6">'.get_the_title().'</h6>';
                        $return_value .= '<div class="indiedev-presskit-entry">'.get_the_content().'</div>';
                    }
                    $return_value .= '</div><br />';
                } 
                
                wp_reset_postdata();
            }
            
            if (trim($the_game['logo'])!='' || trim($the_game['icon'])!='') {
                $the_title = '';
                $the_logo = false;
                $the_icon = false;
                if (trim($the_game['logo'])!='') { $the_logo = true; }    
                if (trim($the_game['icon'])!='') { $the_icon = true; }
                
                if($the_logo && $the_icon) {
                    $the_title = __('Logo & Icon', 'indiedev-game-marketer');
                } else {
                    if($the_logo) {
                        $the_title = __('Logo', 'indiedev-game-marketer');
                    }           
                    if($the_icon) {
                        $the_title = __('Icon', 'indiedev-game-marketer');
                    }                    
                }
                
                $return_value .= '<div class="indiedev-presskit-logo indiedev-presskit-entry">';
                $return_value .= '<h3 class="indiedev-h3">'.$the_title.'</h3><a name="indiedev-presskit-logo"></a>';
                if($the_logo) {
                    $return_value .= '<img src="'.$this->fix_link($the_game['logo']).'" alt="'.htmlentities($the_game['name']).' '.__('Logo', 'indiedev-game-marketer').'" />';
                }           
                if($the_icon) {
                    $return_value .= '<img src="'.$this->fix_link($the_game['icon']).'" alt="'.htmlentities($the_game['name']).' '.__('Icon', 'indiedev-game-marketer').'" />';
                }   
                $return_value .= '</div><br />';
                $contents_return_value .= '     <li class="indiedev-list-item"><a href="#indiedev-presskit-logo" class="indiedev-link">'.$the_title.'</a></li>';
            }            
            
            $the_query = new WP_Query( array(
                'post_status' => 'publish',
                'meta_key' => 'idgm_promo_game_choice', 
                'meta_value' => "{$game_id}",
                'post_type' => 'press_releases',  
            ));
            if ($the_query->have_posts()) {                
                $return_value .= '<a name="indiedev-presskit-item-press-releases"></a><div class="indiedev-presskit-press-releases indiedev-presskit-entry">';
                $return_value .= '<h3 class="indiedev-h3">'.__('Press Releases','indiedev-game-marketer').'</h3><ul>';
                $contents_return_value .= '     <li><a href="#indiedev-presskit-item-press-releases" class="indiedev-link">'.__('Press Releases','indiedev-game-marketer').'</a></li>';
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $return_value .= '<li><a href="'.get_the_permalink().'" class="indiedev-link">'.get_the_title().'</a></li>';
                }
                $return_value .= '</ul></div><br />';                
            }
            wp_reset_postdata();
            
            if (trim($indiedev_options['Indiedev_Game_Marketer_text_company_desc'])!='') {
                $return_value .= '<div class="indiedev-presskit-about-company indiedev-presskit-entry">';
                $return_value .= '<h3 class="indiedev-h3">'.__('About', 'indiedev-game-marketer').' '. $indiedev_options['Indiedev_Game_Marketer_text_company_name'] .'</h3><a name="indiedev-presskit-about-company"></a>';
                $return_value .= $indiedev_options['Indiedev_Game_Marketer_text_company_desc'];
                $return_value .= '</div><br />';
                $contents_return_value .= '     <li class="indiedev-list-item"><a href="#indiedev-presskit-about-company" class="indiedev-link">'.__('About', 'indiedev-game-marketer').' '. $indiedev_options['Indiedev_Game_Marketer_text_company_name'].'</a></li>';
            }
            
            $return_value .= '<div class="indiedev-presskit-bottom">';
            $contents_return_value .= '     <li class="indiedev-list-item"><a href="#indiedev-presskit-credits" class="indiedev-link">'.__('Credits', 'indiedev-game-marketer').'</a></li>';
            $return_value .= '<a name="indiedev-presskit-credits"></a><div class="indiedev-presskit-credits indiedev-presskit-entry">';
            $return_value .= '<h3 class="indiedev-h3">'.__('Credits', 'indiedev-game-marketer').'</h3>';            
            $return_value .= "<ul class='indiedev-list'>";
            if(trim($the_game['developers'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Developers', 'indiedev-game-marketer'). "</strong>: " . $the_game['developers'] . "</li>";
            }
            if(trim($the_game['publishers'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Publishers', 'indiedev-game-marketer'). "</strong>: " . $the_game['publishers'] . "</li>";
            }            
            if(trim($the_game['distributors'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Distributors', 'indiedev-game-marketer'). "</strong>: " . $the_game['distributors'] . "</li>";
            }      
            if(trim($the_game['producers'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Producers', 'indiedev-game-marketer'). "</strong>: " . $the_game['producers'] . "</li>";
            }            
            if(trim($the_game['designers'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Designers', 'indiedev-game-marketer'). "</strong>: " . $the_game['designers'] . "</li>";
            }      
            if(trim($the_game['programmers'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Programmers', 'indiedev-game-marketer'). "</strong>: " . $the_game['programmers'] . "</li>";
            }      
            if(trim($the_game['artists'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Artists', 'indiedev-game-marketer'). "</strong>: " . $the_game['artists'] . "</li>";
            }   
            if(trim($the_game['writers'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Writers', 'indiedev-game-marketer'). "</strong>: " . $the_game['writers'] . "</li>";
            }               
            if(trim($the_game['composers'])!='') {
                $return_value .= "<li class='indiedev-list-item'><strong>".__('Composers', 'indiedev-game-marketer'). "</strong>: " . $the_game['composers'] . "</li>";
            }                   
            $return_value .= "</ul>";
            $return_value .= '</div>';            
            $contents_return_value .= '     <li><a href="#indiedev-presskit-contact" class="indiedev-link">'.__('Contact', 'indiedev-game-marketer').'</a></li>';
            $return_value .= '<a name="indiedev-presskit-contact"></a><div class="indiedev-presskit-contact indiedev-presskit-entry">';
            $return_value .= '<h3 class="indiedev-h3">'.__('Contact', 'indiedev-game-marketer').'</h3>';    
            $return_value .= "<ul class='indiedev-list'>";   
            if(trim($indiedev_options['Indiedev_Game_Marketer_textarea_company_main_press_email'])!='') {
                $return_value .= "  <li class='indiedev-list-item'><strong>". __('Inquiries', 'indiedev-game-marketer') ."</strong>: <a href='mailto://".$indiedev_options['Indiedev_Game_Marketer_textarea_company_main_press_email']."'>". $indiedev_options['Indiedev_Game_Marketer_textarea_company_main_press_email'] . "</a></li>";
            }
            if(trim($indiedev_options['Indiedev_Game_Marketer_text_company_website'])!='') {
                $return_value .= "  <li class='indiedev-list-item'><strong>". __('Website', 'indiedev-game-marketer') ."</strong>: <a href='". $this->fix_link($indiedev_options['Indiedev_Game_Marketer_text_company_website']) . "'>". $indiedev_options['Indiedev_Game_Marketer_text_company_website'] . "</a></li>";
            }         
            if(trim($indiedev_options['Indiedev_Game_Marketer_text_company_pr_phone'])!='') {
                $return_value .= "  <li class='indiedev-list-item'><strong>". __('Phone', 'indiedev-game-marketer') ."</strong>: ". $indiedev_options['Indiedev_Game_Marketer_text_company_pr_phone'] . "</li>";
            }              
            if(trim($indiedev_options['Indiedev_Game_Marketer_text_company_twitter'])!='') {
                $return_value .= "  <li class='indiedev-list-item'><strong>". __('Twitter', 'indiedev-game-marketer') ."</strong>: <a href='https://twitter.com/".$this->fix_twitter_link($indiedev_options['Indiedev_Game_Marketer_text_company_twitter'])."'>@". $this->fix_twitter_link($indiedev_options['Indiedev_Game_Marketer_text_company_twitter']) . "</a></li>";
            }    
            if(trim($indiedev_options['Indiedev_Game_Marketer_text_company_youtube'])!='') {
                $return_value .= "  <li class='indiedev-list-item'><strong>". __('YouTube', 'indiedev-game-marketer') ."</strong>: <a href='". $this->fix_link($indiedev_options['Indiedev_Game_Marketer_text_company_youtube']) . "'>". $indiedev_options['Indiedev_Game_Marketer_text_company_youtube'] . "</a></li>";
            }   
            if(trim($indiedev_options['Indiedev_Game_Marketer_text_company_facebook'])!='') {
                $return_value .= "  <li class='indiedev-list-item'><strong>". __('Facebook', 'indiedev-game-marketer') ."</strong>: <a href='". $this->fix_facebook_link($indiedev_options['Indiedev_Game_Marketer_text_company_facebook']) . "'>". $indiedev_options['Indiedev_Game_Marketer_text_company_facebook'] . "</a></li>";
            }             
            $return_value .= "</ul>";            
            $return_value .= '</div>';                             
            $return_value .= '</div>';
            
            $contents_return_value .= '</ul></div>';
            $return_value = $contents_return_value . $return_value; // Combine them
            $return_value .= '</div></div>';
            
            return $return_value;
        }         
        
        public function indiedev_game_marketer_shortcode($attribs) {
            
            $returned_string_var = '';
            
            $shortcode_attributes = shortcode_atts( array(
                'display' => 'company', // can be: (company, name, roles, email, website, facebook, twitter, youtube) <- all company
                                        // can also be: (game, name, logo, icon, small_desc, long_desc, genres, multiplayer, home_url, developers, publishers, distributors, producers, designers, programmers, artists, writers, composers, game_engine, franchise_series, platform_a, release_date_a, platform_b, release_date_b, platform_c, release_date_c, platform_d, release_date_d, platform_e, release_date_e, platform_f, release_date_f, platform_g, release_date_g, platform_h, release_date_h, platform_i, release_date_i, platform_j, release_date_j) ) <- all for the game
                                        // can also be: presskit
                'style' => 'ul', // can be ul, li, none
                'label' => 'true',
                'game' => '0',
                'tag' => '', // 
            ), $attribs );            
                       
            
            if (strtolower($shortcode_attributes['display']) == 'presskit' ) { # Shortcode for dumping the presskit
                $returned_string_var .= $this->idgm_display_presskit(intval($shortcode_attributes['game']));
            } elseif (strtolower($shortcode_attributes['display']) == 'company' ) { # Shortcode for dumping the company's info
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_name', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_desc', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_select_company_business_activity_main', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_select_company_business_activity_secondary', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_textarea_company_main_press_email', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_website', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_facebook', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_twitter', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_youtube', $shortcode_attributes['style'], $shortcode_attributes['label']);
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_pr_phone', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'name' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_name', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'roles' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_select_company_business_activity_main', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'email' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_textarea_company_main_press_email', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'website' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_website', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'facebook' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_facebook', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'twitter' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_twitter', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'youtube' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_youtube', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'location' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_location', $shortcode_attributes['style'], $shortcode_attributes['label']);
            } elseif (strtolower($shortcode_attributes['display']) == 'companydesc' ) {
                if (strtolower($shortcode_attributes['style']) == 'ul' ) { 
                    $shortcode_attributes['style'] = 'none'; // ul is the default, but since by default we don't want single values in it's own ul, it is disabled here
                }
                $returned_string_var .= $this->prepare_option_for_display('Indiedev_Game_Marketer_text_company_desc', $shortcode_attributes['style'], $shortcode_attributes['label']);
                
            } else {
                
                $returned_string_var .= $this->prepare_game_for_display(intval($shortcode_attributes['game']), strtolower($shortcode_attributes['display']), strtolower($shortcode_attributes['style']), strtolower($shortcode_attributes['label']), strtolower($shortcode_attributes['tag']));
            }
            
            return do_shortcode($returned_string_var);
            
        }
        
        
        
        public static function get_games($fields='*') {
            global $wpdb;
            $results = $wpdb->get_results('SELECT '.$fields.' FROM `'.$wpdb->prefix.'idgm_games`;', ARRAY_A);
            return $results;
        }
        
        public static function get_game($game_id_raw, $fields='*') {
            global $wpdb;
            $game_id = intval($game_id_raw);
            $results = $wpdb->get_results('SELECT '.$fields.' FROM `'.$wpdb->prefix.'idgm_games` WHERE `id`='.$game_id.';', ARRAY_A);
            if (isset($results)) {
                return $results[0];
            } else {
                return null;
            }
        }        
        
        public function create_new_network_blog($blog_id, $user_id, $domain, $path, $site_id, $meta) {
            global $wpdb, $idgm_flush_rules;

            if (is_plugin_active_for_network('indiedev-game-marketer/indiedev-game-marketer.php')) {
                $old_blog = $wpdb->blogid;
                switch_to_blog($blog_id);
                require_once WP_PLUGIN_DIR . '/indiedev-game-marketer/includes/class-indiedev-game-marketer-activator.php';
                Indiedev_Game_Marketer_Activator::createDb();
                $idgm_flush_rules = true;
                restore_current_blog();
            }            
         
        }
        
        public function implement_upgrade() {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            require_once WP_PLUGIN_DIR . '/indiedev-game-marketer/includes/class-indiedev-game-marketer-activator.php';
            Indiedev_Game_Marketer_Activator::upgrade(is_network_only_plugin('indiedev-game-marketer/indiedev-game-marketer.php'));
        }
        
        public function get_games_greenlight_steam_url($game_id) {
            $greenlight_url = $this->get_game($game_id, '`greenlight_url`');
            $steam_url = str_replace('http://steamcommunity.com/sharedfiles/filedetails/?id=', 'steam://url/CommunityFilePage/', $greenlight_url['greenlight_url']);
            return $steam_url;
        }
        
        public function greenlight_parse_request($wp) {
            
            if( stristr($_SERVER['HTTP_USER_AGENT'],'ipad') || stristr($_SERVER['HTTP_USER_AGENT'],'iphone') || strstr($_SERVER['HTTP_USER_AGENT'],'iphone') || stristr($_SERVER['HTTP_USER_AGENT'],'blackberry') || stristr($_SERVER['HTTP_USER_AGENT'],'android') ) {
                $isMobile = true;
            } else {
                $isMobile = false;
            }										
            if (array_key_exists('greenlight', $wp->query_vars)) {
                $game_id = intval($wp->query_vars['greenlight']);
                $game_name_raw = $this->get_game($game_id, '`name`');
                $greenlight_url_raw = $this->get_game($game_id, '`greenlight_url`');
                $greenlight_url = $greenlight_url_raw['greenlight_url'];
                $steam_url = $this->get_games_greenlight_steam_url($game_id);
                ?><html>
                <head>
                <?PHP if ($isMobile == false) { ?>
                    <script type="text/javascript">
                    document.addEventListener("DOMContentLoaded", function(event) { 
                        document.body.innerHTML = '<object data="<?PHP echo $greenlight_url; ?>" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; z-index:999999;"><embed src="<?PHP echo $greenlight_url; ?>" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; z-index:999999;"> </embed><center>Your browser doesn\'t support this embedded data. Click <a href="<?PHP echo $greenlight_url; ?>">here</a> to go to the <?PHP echo $game_name_raw['name']; ?> Steam Greenlight page.</center></object>';
                        var href = '<?php echo $steam_url; ?>';
                        var content_source = document.createElement('<?php echo base64_decode('aWZyYW1l'); ?>');
                        var html = "<html><meta http-equiv=\"refresh\" content=\"0; url=\""+href+"\"><body><script>window.location = \""+href+"\";<" + "/"  + "script></body></html>";
                        content_source.src = 'data:text/html;charset=utf-8,' + encodeURI(html);
                        document.body.appendChild(content_source);
                        content_source.contentWindow.document.open();
                        content_source.contentWindow.document.write(html);
                        content_source.contentWindow.document.close();
                    });                 
                    </script>
                <?PHP } ?>                    
                <title><?PHP echo $game_name_raw['name']; ?> Steam Greenlight</title>
                </head>
                <body style="background-color:#000;color:#FFF;margin: 0;">                    

                </body>
                </html><?php
                
            }
        }
            
        public function greenlight_query_vars($vars) {
            $vars[] = 'greenlight';
            return $vars;
        }
        
}
