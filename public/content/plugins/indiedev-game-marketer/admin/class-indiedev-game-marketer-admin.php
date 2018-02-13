<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://blacklodgegames.com
 * @since      1.0.0
 *
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/admin
 * @author     BLACK LODGE GAMES, LLC <jeff@blacklodgegames.com>
 */
class Indiedev_Game_Marketer_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the Settings page.
	 *
	 * @since    1.0.0
	 */
	public function idgm_admin_menu() {

		 add_menu_page( __('IndieDev Game Marketer', $this->plugin_name), __('IndieDev Game Marketer', $this->plugin_name), 'manage_options', $this->plugin_name, array($this, 'display_plugin_admin_page'));
                 add_submenu_page($this->plugin_name, __('IndieDev Game Marketer', $this->plugin_name), __('Add Game Promo', $this->plugin_name), 'edit_posts', 'idgm-add-promo-link', array($this, 'redirect_to_add_promo'));
                 add_submenu_page($this->plugin_name, __('IndieDev Game Marketer', $this->plugin_name), __('Add Press Release', $this->plugin_name), 'edit_posts', 'idgm-add-press-link', array($this, 'redirect_to_add_press_release'));
                 
	}        

        public function redirect_to_add_promo() {
            if(!headers_sent()) {
                header('Location: '.admin_url( 'post-new.php?post_type=promo_materials' ).' ');
                die();                
            }
            echo '<script type="text/javascript">window.location = "'.admin_url( 'post-new.php?post_type=promo_materials' ).'";</script>';
        }
        
        public function redirect_to_add_press_release() {
            if(!headers_sent()) {
                header('Location: '.admin_url( 'post-new.php?post_type=press_releases' ).' ');
                die();                
            }
            echo '<script type="text/javascript">window.location = "'.admin_url( 'post-new.php?post_type=press_releases' ).'";</script>';
        }        
       
        public function add_button( $plugin_array ) {
                $plugin_array['indiedev'] = plugin_dir_url( dirname( __FILE__ ) ) . 'admin/js/idgm-tinymce.js';
                return $plugin_array;
        }        

        public function register_button( $buttons ) {
                array_push($buttons,'idgmoption');
                return $buttons;
        }        
        
        public function Indiedev_Game_Marketer_settings_init(  ) { 

                register_setting( 'Indiedev_Game_Marketer_settings', 'Indiedev_Game_Marketer_settings' );

                add_settings_section(
                        'Indiedev_Game_Marketer_indiedev-game-marketer_basic_section', 
                        __( 'Basic Settings', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_settings_basic_section_callback'), 
                        'indiedev-game-marketer'
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_select_css', 
                        __( 'Use Default CSS', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_select_css'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_basic_section' 
                );                
                
                add_settings_section(
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section', 
                        __( 'Your Company', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_settings_section_callback'), 
                        'indiedev-game-marketer'
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_text_company_name', 
                        __( 'Company Name', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_text_company_name_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_text_company_desc', 
                        __( 'Company Description', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_text_company_desc_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_text_company_location', 
                        __( 'Company Location', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_text_company_location_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );                
                
                add_settings_field( 
                        'Indiedev_Game_Marketer_select_company_business_activity_main', 
                        __( 'Primary Business Activity', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_select_company_business_activity_main_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_select_company_business_activity_secondary', 
                        __( 'Secondary Business Activity', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_select_company_business_activity_secondary_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_textarea_company_main_press_email', 
                        __( 'Main Press Email', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_textarea_company_main_press_email_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_text_company_website', 
                        __( 'Company Website', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_text_company_website_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_text_company_facebook', 
                        __( 'Company Facebook', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_text_company_facebook_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_text_company_twitter', 
                        __( 'Company Twitter', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_text_company_twitter_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_text_company_youtube', 
                        __( 'Company YouTube Channel', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_text_company_youtube_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_text_company_pr_phone', 
                        __( 'Company PR Phone', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_text_company_pr_phone_render'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_indiedev-game-marketer_section' 
                );
                
                add_settings_section(
                        'Indiedev_Game_Marketer_settings_twitter_section', 
                        __( 'Twitter Settings', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_settings_twitter_section_callback'), 
                        'indiedev-game-marketer'
                );

                add_settings_field( 
                        'Indiedev_Game_Marketer_select_twitter_consumer_key', 
                        __( 'Consumer Key (API Key)', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_select_twitter_consumer_key'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_settings_twitter_section' 
                );                 
                
                add_settings_field( 
                        'Indiedev_Game_Marketer_select_twitter_consumer_secret', 
                        __( 'Consumer Secret (API Secret)', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_select_twitter_consumer_secret'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_settings_twitter_section' 
                );                 
                
                add_settings_field( 
                        'Indiedev_Game_Marketer_select_twitter_token', 
                        __( 'OAuth Token', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_select_twitter_token'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_settings_twitter_section' 
                );        

                add_settings_field( 
                        'Indiedev_Game_Marketer_select_twitter_secret', 
                        __( 'OAuth Secret', 'indiedev-game-marketer' ), 
                        array($this, 'Indiedev_Game_Marketer_select_twitter_secret'), 
                        'indiedev-game-marketer', 
                        'Indiedev_Game_Marketer_settings_twitter_section' 
                );                 

                add_meta_box( 'idgm_promo_meta_box',
                    __('Which game is this for?', 'indiedev-game-marketer'),
                    array($this, 'display_idgm_promo_meta_box'),
                    'promo_materials', 'normal', 'high'
                );

                add_meta_box( 'idgm_promo_meta_box',
                    __('Which game is this for?', 'indiedev-game-marketer'),
                    array($this, 'display_idgm_promo_meta_box'),
                    'press_releases', 'normal', 'high'
                );                
                
        }        
        
        public function display_idgm_promo_meta_box($promo_post) {
            echo '<table class="widefat" id="idgm_select_promo_game_list"><tr><td><select style="width: 100%;" name="idgm_promo_game_choice">';
            $game_results = Indiedev_Game_Marketer_Public::get_games();
            $idgm_promo_game_choice =  get_post_meta( get_the_ID(), 'idgm_promo_game_choice', true ) ;
            if(isset($game_results[0])) {
                foreach ($game_results as $game) {
                    echo "<option value='{$game['id']}' ".selected( $game['id'], $idgm_promo_game_choice ).">{$game['name']}</option>";
                }
            }
            echo '</select></td></tr></table>';            
        }

        public function idgm_save_promo_game_id($promo_id, $promo_post=null) {

                if ( isset( $_POST['idgm_promo_game_choice'] ) && $_POST['idgm_promo_game_choice'] != '' ) {
                    update_post_meta( get_the_ID(), 'idgm_promo_game_choice', intval($_POST['idgm_promo_game_choice']) );
                }  

        }
        
        public function Indiedev_Game_Marketer_select_css(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <select name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_select_css]'>
                        <option value='on' <?php selected( $options['Indiedev_Game_Marketer_select_css'], 'on' ); ?>><?php  _e( 'Include CSS', 'indiedev-game-marketer' ); ?></option>
                        <option value='off' <?php selected( $options['Indiedev_Game_Marketer_select_css'], 'off' ); ?>><?php  _e( 'Disable CSS', 'indiedev-game-marketer' ); ?></option>
                </select>
                    <br /><i><?php _e( "Do you want to use the default CSS for the presskits?  If you disable this you should probably include your own CSS in your theme's file.  See the documentation for full CSS documentation.", 'indiedev-game-marketer' ); ?></i>
        </div><?php

        }        
        
        public function Indiedev_Game_Marketer_text_company_name_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?>
                <div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_text_company_name]' value='<?php echo $options['Indiedev_Game_Marketer_text_company_name']; ?>'>
                <br /><?php _e( "Individuals, feel free to use your own name in place of the company name.", 'indiedev-game-marketer' ); ?>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=name label=false]</strong>
                </div><?php

        }

        public function Indiedev_Game_Marketer_text_company_desc_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?>
                <div class="idgm-box">
                <textarea style="width:100%;" name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_text_company_desc]'><?php echo $options['Indiedev_Game_Marketer_text_company_desc']; ?></textarea>
                <br /><?php _e( "Explain the company or individual in a paragraph.  It's a good idea to start with where and when the company was formed.", 'indiedev-game-marketer' ); ?>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=companydesc label=false]</strong>
                </div><?php

        }        

        public function Indiedev_Game_Marketer_text_company_location_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?>
                <div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_text_company_location]' value='<?php echo $options['Indiedev_Game_Marketer_text_company_location']; ?>'>
                <br /><?php _e( "This is used in press releases and should not be the full address, but instead just your state or province and country.  For example: Seattle, WA, USA", 'indiedev-game-marketer' ); ?>
                </div><?php

        }        
        
        public function Indiedev_Game_Marketer_select_company_business_activity_main_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <select name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_select_company_business_activity_main]'>
                        <option value='Development' <?php selected( $options['Indiedev_Game_Marketer_select_company_business_activity_main'], 'Development' ); ?>><?php  _e( 'Development', 'indiedev-game-marketer' ); ?></option>
                        <option value='Publishing' <?php selected( $options['Indiedev_Game_Marketer_select_company_business_activity_main'], 'Publishing' ); ?>><?php  _e( 'Publishing', 'indiedev-game-marketer' ); ?></option>
                        <option value='Marketing' <?php selected( $options['Indiedev_Game_Marketer_select_company_business_activity_main'], 'Marketing' ); ?>><?php  _e( 'Marketing', 'indiedev-game-marketer' ); ?></option>
                </select>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=roles label=false]</strong>
        </div><?php

        }


        public function Indiedev_Game_Marketer_select_company_business_activity_secondary_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <select name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_select_company_business_activity_secondary]'>
                        <option value='none' <?php selected( $options['Indiedev_Game_Marketer_select_company_business_activity_secondary'], 'none' ); ?>> </option>
                        <option value='Development' <?php selected( $options['Indiedev_Game_Marketer_select_company_business_activity_secondary'], 'Development' ); ?>><?php  _e( 'Development', 'indiedev-game-marketer' ); ?></option>
                        <option value='Publishing' <?php selected( $options['Indiedev_Game_Marketer_select_company_business_activity_secondary'], 'Publishing' ); ?>><?php  _e( 'Publishing', 'indiedev-game-marketer' ); ?></option>
                        <option value='Marketing' <?php selected( $options['Indiedev_Game_Marketer_select_company_business_activity_secondary'], 'Marketing' ); ?>><?php  _e( 'Marketing', 'indiedev-game-marketer' ); ?></option>
                </select>
        </div><?php

        }


        public function Indiedev_Game_Marketer_textarea_company_main_press_email_render(  ) { 

            
                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_textarea_company_main_press_email]' value='<?php echo $options['Indiedev_Game_Marketer_textarea_company_main_press_email']; ?>'>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=email label=false]</strong>
                </div><?php
            
        }


        public function Indiedev_Game_Marketer_text_company_website_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_text_company_website]' value='<?php echo $options['Indiedev_Game_Marketer_text_company_website']; ?>'>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=website label=false]</strong>
                </div><?php

        }


        public function Indiedev_Game_Marketer_text_company_facebook_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_text_company_facebook]' value='<?php echo $options['Indiedev_Game_Marketer_text_company_facebook']; ?>'>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=facebook label=false]</strong>
                </div><?php

        }


        public function Indiedev_Game_Marketer_text_company_twitter_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_text_company_twitter]' value='<?php echo $options['Indiedev_Game_Marketer_text_company_twitter']; ?>'>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=twitter label=false]</strong>
                </div><?php

        }


        public function Indiedev_Game_Marketer_text_company_youtube_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_text_company_youtube]' value='<?php echo $options['Indiedev_Game_Marketer_text_company_youtube']; ?>'>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=youtube label=false]</strong>
                </div><?php

        }


        public function Indiedev_Game_Marketer_text_company_pr_phone_render(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_text_company_pr_phone]' value='<?php echo $options['Indiedev_Game_Marketer_text_company_pr_phone']; ?>'>
                <br /><i><?php _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); ?></i> <strong>[indiedev display=phone label=false]</strong>
                </div><?php

        }

        public function Indiedev_Game_Marketer_settings_basic_section_callback(  ) { 

                _e( "The Settings tab is used to define basic options.", 'indiedev-game-marketer' );

        }
        
        
        public function Indiedev_Game_Marketer_settings_twitter_section_callback(  ) { 

                _e( "The Twitter Settings are used to authenticate your Twitter account so that you can autopost to Twitter using the Social tab.  After you enter new values for these settings, click the Save Changes button and then a new button will appear labeled Test Twitter Authentication.  If the test is successful, you can begin using the Social tab to autopost to Twitter.", 'indiedev-game-marketer' );
                echo '<br />';
                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                if(trim($options['Indiedev_Game_Marketer_select_twitter_consumer_key'])!='' && trim($options['Indiedev_Game_Marketer_select_twitter_consumer_secret'])!='' && trim($options['Indiedev_Game_Marketer_select_twitter_token'])!='' && trim($options['Indiedev_Game_Marketer_select_twitter_secret'])!='') {
                    echo '<br /><a href="#" class="button-secondary idgm-test-twitter-button">'.__('Test Twitter Authentication','indiedev-game-marketer').'</a>';
                }
        }        
        
        public function Indiedev_Game_Marketer_settings_section_callback(  ) { 

                _e( "These settings define your company.  After saving these details, some of these details will be used as defaults for other values in the plugin.  Because of that, it is recommended that you fill out these settings first.", 'indiedev-game-marketer' );
                echo '<br /><br /><i>' ;   
                _e( "Display this content in your Pages and Post by pasting this shortcode:", 'indiedev-game-marketer' ); 
                echo '</i> <strong>[indiedev]</strong>';
        }

       public function Indiedev_Game_Marketer_select_twitter_consumer_key(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_select_twitter_consumer_key]' value='<?php echo $options['Indiedev_Game_Marketer_select_twitter_consumer_key']; ?>'>                
                <br /><i><?php _e( "To proceed, you need to first create and publish a Twitter App.  Full instructions on how to do that are located here", 'indiedev-game-marketer' ); ?></i>: <a href="http://blacklodgegames.com/indiedev-game-marketer-wp-plugin-for-wordpress/#socialmedia">http://blacklodgegames.com/indiedev-game-marketer-wp-plugin-for-wordpress/</a>                
                </div><?php

        }         
        
        public function Indiedev_Game_Marketer_select_twitter_consumer_secret(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_select_twitter_consumer_secret]' value='<?php echo $options['Indiedev_Game_Marketer_select_twitter_consumer_secret']; ?>'>
                </div><?php

        }           
        
        public function Indiedev_Game_Marketer_select_twitter_token(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_select_twitter_token]' value='<?php echo $options['Indiedev_Game_Marketer_select_twitter_token']; ?>'>
                </div><?php

        }        
        
       public function Indiedev_Game_Marketer_select_twitter_secret(  ) { 

                $options = get_option( 'Indiedev_Game_Marketer_settings' );
                ?><div class="idgm-box">
                <input type='text' name='Indiedev_Game_Marketer_settings[Indiedev_Game_Marketer_select_twitter_secret]' value='<?php echo $options['Indiedev_Game_Marketer_select_twitter_secret']; ?>'>                
                </div><?php

        }          
        
        public function Indiedev_Game_Marketer_presskit_page() {
            _e('To create a press kit for a game, you should first fill out the Settings tab, then create a game in the games tab, and finally, you should add your best screenshots, videos, press coverage, and awards by Adding New Promos.', 'indiedev-game-marketer');
            echo '<br /><br /><div class="idgm-box"><a class="button-secondary" href="' . admin_url( 'post-new.php?post_type=promo_materials' ) . '"><strong style="font-size:100%;">'.__( "Add New Promo", 'indiedev-game-marketer' ).'</strong></a> <a class="button-secondary" href="' . admin_url( 'edit.php?post_type=promo_materials' ) . '"><strong style="font-size:100%;">'.__( "View All Promos", 'indiedev-game-marketer' ).'</strong></a><br /><i><strong style="font-size:100%;">'.__( "Note that you will lose any unsaved changes on the Settings tab if you click either of these buttons.", 'indiedev-game-marketer' ).'</strong></i></div><br />';
            _e("Once you have created some or all of the content for your game's press kit, you can use the buttons below to create a page that will act as the press-kit.", 'indiedev-game-marketer');
            echo '<table class="widefat" id="idgm_edit_presskit_list">';
            $game_results = Indiedev_Game_Marketer_Public::get_games();
            if(isset($game_results[0])) {
                foreach ($game_results as $game) {
                    echo "<tr id='idgm_edit_presskit_table_row_{$game['id']}'><td style='width:115px;' id='idgm_edit_presskit_table_id_{$game['id']}'>";
                    if ($game['page']==0) {
                        echo "<a href='#' class='button-secondary idgm-create-presskit-button' id='idgm-presskit-button-{$game['id']}' onclick='idgm_create_presskit_click({$game['id']});'>".__('Create Page','indiedev-game-marketer')."</a>";
                    } else {
                        if (false === get_post_status($game['page'])){
                            echo "<a href='#' class='button-secondary idgm-create-presskit-button' id='idgm-presskit-button-{$game['id']}' onclick='idgm_create_presskit_click({$game['id']});'>".__('Create Page','indiedev-game-marketer')."</a>";
                        } else {   
                            echo "<a href='".admin_url('post.php?post='.$game['page'].'&action=edit')."' class='button-secondary idgm-edit-presskit-button'>".__('Edit Page','indiedev-game-marketer')."</a>";
                        }
                    }
                    echo "</td><td>{$game['name']}</td></tr>";
                }
            }
            echo '</table>';            
        }
      
        public function Indiedev_Game_Marketer_social_page() {
            global $wpdb;
            
            echo '<h3>' . __('Twitter Autoposter', 'indiedev-game-marketer').'</h3>';
            echo '<table class="widefat" id="idgm_twitter_outer_table" style="width:100%;border:1px solid #DDDDDD;"><tr><td>';
            echo '<table class="widefat" id="idgm_twitter_autoposter" style="width:100%;">';
            echo '<textarea id="idgm-tweet-box" style="width:100%;"></textarea><br /><a href="#" id="idgm-upload-twitter-button" class="button-secondary">'.__('Add Images', 'indiedev-game-marketer').'</a> <div id="idgm-twitter-images"> </div> &nbsp; &nbsp; &nbsp; <a class="button-primary idgm-tweet-button" href="#" style="float:right;">'.__('Tweet', 'indiedev-game-marketer').'</a> <div id="idgm-twitter-characters" style="float:right;">140</div><br style="clear:both;" /><div style="float:left;"> <select id="idgm-twitter-select"><option value="now">'.__('Post this immediately', 'indiedev-game-marketer').'</option><option value="once">'.__('Post this once, at the following time', 'indiedev-game-marketer').'</option><option value="repeat">'.__('Make a new tweet using this template on the following schedule', 'indiedev-game-marketer').'</option></select><br /> <div style="display:none" id="idgm-date-time-div">'.__('Date', 'indiedev-game-marketer').': <select style="display:none;" id="idgm-tweet-schedule"><option value="daily">'.__('Daily', 'indiedev-game-marketer').'</option><option value="monday">'.__('Every Monday', 'indiedev-game-marketer').'</option><option value="tuesday">'.__('Every Tuesday', 'indiedev-game-marketer').'</option><option value="wednesday">'.__('Every Wednesday', 'indiedev-game-marketer').'</option><option value="thursday">'.__('Every Thursday', 'indiedev-game-marketer').'</option><option value="friday">'.__('Every Friday', 'indiedev-game-marketer').'</option><option value="saturday">'.__('Every Saturday', 'indiedev-game-marketer').'</option><option value="sunday">'.__('Every Sunday', 'indiedev-game-marketer').'</option></select> <input id="idgm-tweet-date" style="width:120px;" value="'.date('Y-m-d').'" />   '.__('Time', 'indiedev-game-marketer').': </a> <input id="idgm-tweet-time" value="'.date('H:i').'"  style="width:120px;" /> <div id="idgm-twitter-auto-attach-div" style="display:none;"> '.__('Auto Attach Images', 'indiedev-game-marketer').': <select id="idgm-tweet-auto-attach"><option val="none">'.__('None', 'indiedev-game-marketer').'</option></select></div></div></div>';                            
            echo '<input type="hidden" id="idgm_tweet-image1" /><input type="hidden" id="idgm_tweet-image2" /><input type="hidden" id="idgm_tweet-image3" /><input type="hidden" id="idgm_tweet-image4" />';
            echo '</table></td></tr></table>';            

            echo '<div id="idgm-tweets-list"></div>';
            
        }        
        
        public function Indiedev_Game_Marketer_more_page() {
            global $wpdb;
            
            echo '<h3>' . __('Game Marketing Resources', 'indiedev-game-marketer').'</h3>';
            echo '<table class="widefat" style="width:100%;border:1px solid #DDDDDD;"><tr><td>';
            _e('The following links and resources were not created by me and are not sponsored, nor am I affiliated with these sites in any way.  Rather these are all resources that I feel are great for indie game marketing.  Please email me if you have any suggestions for content that belongs in this list!', 'indiedev-game-marketer');
            echo '</td></tr></table>';            
            echo '<br /><h4>'.__('Other Marketing Tools', 'indiedev-game-marketer').'</h4>';
            ?>
             
            <ul>
                <li><a href="http://dopresskit.com/">presskit()</a> - <?php _e('by Rami Ismail, this is the legendary press kit creation tool that inspired me to create this plugin.', 'indiedev-game-marketer');?></li>
                <li><a href="http://www.indiegamegirl.com/press-release-template/">A Press Release Template</a> - <?php _e('by IndieGameGirl, provides a press release template for indie gamedevs.', 'indiedev-game-marketer');?></li>
                <li><a href="https://dodistribute.com/">distribute()</a> - <?php _e('A tool to keep track of press lists and build distributions, also developed by Rami Ismail.', 'indiedev-game-marketer');?></li>
            </ul>

            <br /><h4><?php _e('Game Marketing Guides', 'indiedev-game-marketer');?></h4>

            <ul>
                <li><a href="https://gamedevelopment.tutsplus.com/articles/an-indie-game-developers-marketing-checklist-including-portable-formats--gamedev-7560">An Indie Game Developer’s Marketing Checklist</a> - <?php _e('A good guide to marketing your game.', 'indiedev-game-marketer');?></li>
                <li><a href="http://www.pixelprospector.com/the-marketing-guide-for-game-developers/">The Marketing Guide for Game Developers</a>  - <?php _e('PixelProspector.com is a site full of gamedev resources.  This is just one of many valuable pages, so check it out!', 'indiedev-game-marketer');?></li>
                <li><a href=""></a></li>
                <li><a href=""></a></li>
            </ul>  

            <br /><h4><?php _e('Sites with Marketing Links &amp; Resources', 'indiedev-game-marketer');?></h4>            
            
            <ul>
                <li><a href="http://www.pixelprospector.com/the-big-list-of-indie-game-marketing/">The Big List Of Indie Game Marketing</a> - <?php _e('PixelProspector.com is a site full of gamedev resources.  This is just one of many valuable pages, so check it out!', 'indiedev-game-marketer');?></li>
                <li><a href="http://www.vlambeer.com/toolkit/">Vlambeer toolkit & link repository</a> - <?php _e(' compilation of the tools Vlambeer uses to develop, market, and release their games.', 'indiedev-game-marketer');?></li>
            </ul>            
            
            <?php
            
            echo '<br /><h4>'.__('YouTube Marketing Playlist', 'indiedev-game-marketer').'</h4>';
            echo wp_oembed_get('https://www.youtube.com/playlist?list=PL9ehGNelCsM3pOkhvzC-rMTwVkx2TEhX4');

            
        }          
        
        public function Indiedev_Game_Marketer_options_page(  ) { 

                ?>
                <form action='options.php' method='post'>

                        <?php
                        settings_fields( 'Indiedev_Game_Marketer_settings' );
                        do_settings_sections( 'indiedev-game-marketer' );
                        submit_button();
                        ?>

                </form>
                <?php

        }
        
        public function Indiedev_Game_Marketer_games_page(  ) { ?>

        <a href="#" class="button-secondary" id="idgm_add_game_button" onclick="jQuery('#idgm_add_game_dialog').toggle( 'fold' );jQuery('#idgm_add_game_button').toggle( 'fold' );"><?php _e( "Add New Game", 'indiedev-game-marketer' ); ?></a>
        <div id="idgm_add_game_dialog" style="display:none" title="<?php _e( "Add New Game", 'indiedev-game-marketer' ); ?>"><h3><?php _e( "Add New Game", 'indiedev-game-marketer' ); ?></h3>
        <table class="form-table"><tbody>
            <tr>
                <th scope="row"><?php _e( "Game's Name", 'indiedev-game-marketer' ); ?></th>
            <td>
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-name' id='idgm-new-game-form-name' value=''>
                <br /><?php _e( "Enter the name of your game, and do not add version numbers or qualifiers like BETA to the game's title.", 'indiedev-game-marketer' ); ?>
                </div>            
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Logo", 'indiedev-game-marketer' ); ?></th>
            <td>                
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-logo' id='idgm-new-game-form-logo' value=''>
                <button class="secondary" id="idgm-upload-button-form-logo"><?php _e( "Upload", 'indiedev-game-marketer' ); ?></button>
                <br /><?php _e( "The game's official logo.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Main Image/Icon", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-icon' id='idgm-new-game-form-icon' value=''>
                <button class="secondary" id="idgm-upload-button-form-icon"><?php _e( "Upload", 'indiedev-game-marketer' ); ?></button>
                <br /><?php _e( "The main digital artwork for the game.  This is usually the cover, and is used in this program as the main icon that represents the game.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Quick Description", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-small-desc' id='idgm-new-game-form-small-desc' value=''>
                <br /><?php _e( "The elevator pitch you use to quickly describe your game in order to capture someone's interest in your game.  Shouldn't be more than a sentence or two.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Full Description", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                    <textarea name='idgm-new-game-form-long-desc' id='idgm-new-game-form-long-desc'></textarea>
                <br /><?php _e( "All the relevent details and sales copy that best explains and sells the concept and execution of your game.  Shortcodes can be used in this field to enhance the content to your liking.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Genres", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-genres' id='idgm-new-game-form-genres' value=''>
                <br /><?php _e( "A list of genres the game belongs to, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Multiplayer Modes", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-multiplayer' id='idgm-new-game-form-multiplayer' value='<?php _e( "Single-player", 'indiedev-game-marketer' ); ?>'>
                <br /><?php _e( "A list of multiplayer modes the game has, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Home URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-home-url' id='idgm-new-game-form-home-url' value=''>
                <br /><?php _e( "The URL to the game's main website.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>  
            <tr>
                <th scope="row"><?php _e( "Greenlight URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-greenlight-url' id='idgm-new-game-form-greenlight-url' value=''>
                <br /><?php _e( "The full URL to the game's Steam Greenlight page, if it had one.  ", 'indiedev-game-marketer' ); ?><br />
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Developers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-developers' id='idgm-new-game-form-developers' value=''>
                <br /><?php _e( "A list of the game's developers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>      
            <tr>
                <th scope="row"><?php _e( "Publishers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-publishers' id='idgm-new-game-form-publishers' value=''>
                <br /><?php _e( "A list of the game's publishers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Distributors", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-distributors' id='idgm-new-game-form-distributors' value=''>
                <br /><?php _e( "A list of the game's notable distributors, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Producers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-producers' id='idgm-new-game-form-producers' value=''>
                <br /><?php _e( "A list of the game's notable producers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>          
            <tr>
                <th scope="row"><?php _e( "Designers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-designers' id='idgm-new-game-form-designers' value=''>
                <br /><?php _e( "A list of the game's notable designers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Programmers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-programmers' id='idgm-new-game-form-programmers' value=''>
                <br /><?php _e( "A list of the game's notable programmers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>  
            <tr>
                <th scope="row"><?php _e( "Artists", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-artists' id='idgm-new-game-form-artists' value=''>
                <br /><?php _e( "A list of the game's notable artists, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>     
            <tr>
                <th scope="row"><?php _e( "Writers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-writers' id='idgm-new-game-form-writers' value=''>
                <br /><?php _e( "A list of the game's notable writers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>     
            <tr>
                <th scope="row"><?php _e( "Composers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-composers' id='idgm-new-game-form-composers' value=''>
                <br /><?php _e( "A list of the game's notable composers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Game Engine", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-game-engine' id='idgm-new-game-form-game-engine' value=''>
                <br /><?php _e( "The engine the game was developed on.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Franchise/Series", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-franchise-series' id='idgm-new-game-form-franchise-series' value=''>
                <br /><?php _e( "If the game is part of a franchise or series, write the name of the franchise or series here.  Otherwise, leave blank.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>  
            <tr>
                <th scope="row"><?php _e( "Platform One", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-a' id='idgm-new-game-form-platform-a' value=''>
                <br /><?php _e( "The platform or console the game is designed for that you wish to list first.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform One", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-a' id='idgm-new-game-form-release-date-a' value=''>
                <br /><?php _e( "The release date or planned release date on platform one.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform One URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-a-url' id='idgm-new-game-form-release-a-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform one.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>              
            <tr>
                <th scope="row"><?php _e( "Platform Two", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-b' id='idgm-new-game-form-platform-b' value=''>
                <br /><?php _e( "The platform or console the game is designed for that you wish to list second.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Two", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-b' id='idgm-new-game-form-release-date-b' value=''>
                <br /><?php _e( "The release date or planned release date on platform two.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>
            <tr>
                <th scope="row"><?php _e( "Platform Two URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-b-url' id='idgm-new-game-form-release-b-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform two.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            <tr>
                <th scope="row"><?php _e( "Platform Three", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-c' id='idgm-new-game-form-platform-c' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Three", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-c' id='idgm-new-game-form-release-date-c' value=''>
                <br /><?php _e( "The release date or planned release date on platform three.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform Three URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-c-url' id='idgm-new-game-form-release-c-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform three.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            <tr>
                <th scope="row"><?php _e( "Platform Four", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-d' id='idgm-new-game-form-platform-d' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Four", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-d' id='idgm-new-game-form-release-date-d' value=''>
                <br /><?php _e( "The release date or planned release date on platform four.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Platform Four URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-d-url' id='idgm-new-game-form-release-d-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform four.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            <tr>
                <th scope="row"><?php _e( "Platform Five", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-e' id='idgm-new-game-form-platform-e' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Five", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-e' id='idgm-new-game-form-release-date-e' value=''>
                <br /><?php _e( "The release date or planned release date on platform five.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>  
            <tr>
                <th scope="row"><?php _e( "Platform Five URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-e-url' id='idgm-new-game-form-release-e-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform five.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            <tr>
                <th scope="row"><?php _e( "Platform Six", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-f' id='idgm-new-game-form-platform-f' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Six", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-f' id='idgm-new-game-form-release-date-f' value=''>
                <br /><?php _e( "The release date or planned release date on platform six.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Platform Six URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-f-url' id='idgm-new-game-form-release-f-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform six.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            <tr>
                <th scope="row"><?php _e( "Platform Seven", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-g' id='idgm-new-game-form-platform-g' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Seven", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-g' id='idgm-new-game-form-release-date-g' value=''>
                <br /><?php _e( "The release date or planned release date on platform seven.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform Seven URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-g-url' id='idgm-new-game-form-release-g-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform seven.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            <tr>
                <th scope="row"><?php _e( "Platform Eight", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-h' id='idgm-new-game-form-platform-h' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Eight", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-h' id='idgm-new-game-form-release-date-h' value=''>
                <br /><?php _e( "The release date or planned release date on platform eight.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>  
            <tr>
                <th scope="row"><?php _e( "Platform Eight URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-h-url' id='idgm-new-game-form-release-h-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform eight.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            <tr>
                <th scope="row"><?php _e( "Platform Nine", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-i' id='idgm-new-game-form-platform-i' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Nine", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-i' id='idgm-new-game-form-release-date-i' value=''>
                <br /><?php _e( "The release date or planned release date on platform nine.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Platform Nine URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-i-url' id='idgm-new-game-form-release-i-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform nine.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            <tr>
                <th scope="row"><?php _e( "Platform Ten", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-platform-j' id='idgm-new-game-form-platform-j' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Ten", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-date-j' id='idgm-new-game-form-release-date-j' value=''>
                <br /><?php _e( "The release date or planned release date on platform ten.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Platform Ten URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-new-game-form-release-j-url' id='idgm-new-game-form-release-j-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform ten.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>            
            </tbody></table><br /><a href="#" class="button-secondary" id="idgm_add_game_button" onclick="jQuery('#idgm_add_game_dialog').toggle( 'fold' );jQuery('#idgm_add_game_button').toggle( 'fold' );"><?php _e( "Close", 'indiedev-game-marketer' ); ?></a> <a href="#" class="button-primary" id="idgm-new-game-form-save-button"><?php _e( "Save Game", 'indiedev-game-marketer' ); ?></a></div>
        
            <h3><?php _e( "Edit Games", 'indiedev-game-marketer' ); ?></h3>  

        <div id="idgm_edit_game_dialog" style="display:none" title="<?php _e( "Edit Game", 'indiedev-game-marketer' ); ?>"><h3><?php _e( "Edit Game", 'indiedev-game-marketer' ); ?></h3>
            <input type="hidden" name="idgm-edit-game-form-id" id="idgm-edit-game-form-id" value=""></input>
        <table class="form-table"><tbody>
            <tr>
                <th scope="row"><?php _e( "Game's Name", 'indiedev-game-marketer' ); ?></th>
            <td>
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-name' id='idgm-edit-game-form-name' value=''>
                <br /><?php _e( "Enter the name of your game, and do not add version numbers or qualifiers like BETA to the game's title.", 'indiedev-game-marketer' ); ?>
                </div>            
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Logo", 'indiedev-game-marketer' ); ?></th>
            <td>                
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-logo' id='idgm-edit-game-form-logo' value=''>
                <button class="secondary" id="idgm-upload-button-edit-form-logo"><?php _e( "Upload", 'indiedev-game-marketer' ); ?></button>
                <br /><?php _e( "The game's official logo.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Main Image/Icon", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-icon' id='idgm-edit-game-form-icon' value=''>
                <button class="secondary" id="idgm-upload-button-edit-form-icon"><?php _e( "Upload", 'indiedev-game-marketer' ); ?></button>
                <br /><?php _e( "The main digital artwork for the game.  This is usually the cover, and is used in this program as the main icon that represents the game.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Quick Description", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-small-desc' id='idgm-edit-game-form-small-desc' value=''>
                <br /><?php _e( "The elevator pitch you use to quickly describe your game in order to capture someone's interest in your game.  Shouldn't be more than a sentence or two.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Full Description", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                    <textarea name='idgm-edit-game-form-long-desc' id='idgm-edit-game-form-long-desc'></textarea>
                <br /><?php _e( "All the relevent details and sales copy that best explains and sells the concept and execution of your game.  Shortcodes can be used in this field to enhance the content to your liking.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Genres", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-genres' id='idgm-edit-game-form-genres' value=''>
                <br /><?php _e( "A list of genres the game belongs to, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Multiplayer Modes", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-multiplayer' id='idgm-edit-game-form-multiplayer' value=''>
                <br /><?php _e( "A list of multiplayer modes the game has, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Home URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-home-url' id='idgm-edit-game-form-home-url' value=''>
                <br /><?php _e( "The URL to the game's main website.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Greenlight URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-greenlight-url' id='idgm-edit-game-form-greenlight-url' value=''>
                <br /><?php _e( "The full URL to the game's Steam Greenlight page, if it had one.", 'indiedev-game-marketer' ); ?><br />
                </div> 
            </td></tr>               
            <tr>
                <th scope="row"><?php _e( "Developers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-developers' id='idgm-edit-game-form-developers' value=''>
                <br /><?php _e( "A list of the game's developers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>      
            <tr>
                <th scope="row"><?php _e( "Publishers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-publishers' id='idgm-edit-game-form-publishers' value=''>
                <br /><?php _e( "A list of the game's publishers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Distributors", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-distributors' id='idgm-edit-game-form-distributors' value=''>
                <br /><?php _e( "A list of the game's notable distributors, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Producers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-producers' id='idgm-edit-game-form-producers' value=''>
                <br /><?php _e( "A list of the game's notable producers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>          
            <tr>
                <th scope="row"><?php _e( "Designers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-designers' id='idgm-edit-game-form-designers' value=''>
                <br /><?php _e( "A list of the game's notable designers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Programmers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-programmers' id='idgm-edit-game-form-programmers' value=''>
                <br /><?php _e( "A list of the game's notable programmers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>  
            <tr>
                <th scope="row"><?php _e( "Artists", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-artists' id='idgm-edit-game-form-artists' value=''>
                <br /><?php _e( "A list of the game's notable artists, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>     
            <tr>
                <th scope="row"><?php _e( "Writers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-writers' id='idgm-edit-game-form-writers' value=''>
                <br /><?php _e( "A list of the game's notable writers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>     
            <tr>
                <th scope="row"><?php _e( "Composers", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-composers' id='idgm-edit-game-form-composers' value=''>
                <br /><?php _e( "A list of the game's notable composers, separated by commas.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Game Engine", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-engine' id='idgm-edit-game-engine' value=''>
                <br /><?php _e( "The engine the game was developed on.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Franchise/Series", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-franchise-series' id='idgm-edit-game-form-franchise-series' value=''>
                <br /><?php _e( "If the game is part of a franchise or series, write the name of the franchise or series here.  Otherwise, leave blank.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>  
            <tr>
                <th scope="row"><?php _e( "Platform One", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-a' id='idgm-edit-game-form-platform-a' value=''>
                <br /><?php _e( "The platform or console the game will be released on first.  Your earliest release should be listed here.  Feel free to put Early Access here if the inital launch is not the full finalized release.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform One", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-a' id='idgm-edit-game-form-release-date-a' value=''>
                <br /><?php _e( "The release date or planned release date on platform one.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform One URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-a-url' id='idgm-edit-game-form-release-a-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform one.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Two", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-b' id='idgm-edit-game-form-platform-b' value=''>
                <br /><?php _e( "The platform or console the game is designed for that you wish to list second.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Two", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-b' id='idgm-edit-game-form-release-date-b' value=''>
                <br /><?php _e( "The release date or planned release date on platform two.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>
            <tr>
                <th scope="row"><?php _e( "Platform Two URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-b-url' id='idgm-edit-game-form-release-b-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform two.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Three", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-c' id='idgm-edit-game-form-platform-c' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Three", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-c' id='idgm-edit-game-form-release-date-c' value=''>
                <br /><?php _e( "The release date or planned release date on platform three.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform Three URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-c-url' id='idgm-edit-game-form-release-c-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform three.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Four", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-d' id='idgm-edit-game-form-platform-d' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Four", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-d' id='idgm-edit-game-form-release-date-d' value=''>
                <br /><?php _e( "The release date or planned release date on platform four.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform Four URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-d-url' id='idgm-edit-game-form-release-d-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform four.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Five", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-e' id='idgm-edit-game-form-platform-e' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Five", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-e' id='idgm-edit-game-form-release-date-e' value=''>
                <br /><?php _e( "The release date or planned release date on platform five.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>  
            <tr>
                <th scope="row"><?php _e( "Platform Five URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-e-url' id='idgm-edit-game-form-release-e-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform five.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Six", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-f' id='idgm-edit-game-form-platform-f' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Six", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-f' id='idgm-edit-game-form-release-date-f' value=''>
                <br /><?php _e( "The release date or planned release date on platform six.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform Six URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-f-url' id='idgm-edit-game-form-release-f-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform six.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Seven", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-g' id='idgm-edit-game-form-platform-g' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Seven", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-g' id='idgm-edit-game-form-release-date-g' value=''>
                <br /><?php _e( "The release date or planned release date on platform seven.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform Seven URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-g-url' id='idgm-edit-game-form-release-g-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform seven.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Eight", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-h' id='idgm-edit-game-form-platform-h' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Eight", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-h' id='idgm-edit-game-form-release-date-h' value=''>
                <br /><?php _e( "The release date or planned release date on platform eight.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>   
            <tr>
                <th scope="row"><?php _e( "Platform Eight URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-h-url' id='idgm-edit-game-form-release-h-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform eight.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Nine", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-i' id='idgm-edit-game-form-platform-i' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Nine", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-i' id='idgm-edit-game-form-release-date-i' value=''>
                <br /><?php _e( "The release date or planned release date on platform nine.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Platform Nine URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-i-url' id='idgm-edit-game-form-release-i-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform nine.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            <tr>
                <th scope="row"><?php _e( "Platform Ten", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-platform-j' id='idgm-edit-game-form-platform-j' value=''>
                <br /><?php _e( "An additional platform or console the game is designed for.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>    
            <tr>
                <th scope="row"><?php _e( "Release Date on Platform Ten", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-date-j' id='idgm-edit-game-form-release-date-j' value=''>
                <br /><?php _e( "The release date or planned release date on platform ten.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr> 
            <tr>
                <th scope="row"><?php _e( "Platform Ten URL", 'indiedev-game-marketer' ); ?></th>
            <td>  
                <div class="idgm-box">
                <input type='text' name='idgm-edit-game-form-release-j-url' id='idgm-edit-game-form-release-j-url' value=''>
                <br /><?php _e( "The store page or official URL for the game's release on platform ten.", 'indiedev-game-marketer' ); ?>
                </div> 
            </td></tr>             
            </tbody></table><br /><a href="#" class="button-secondary" id="idgm_edit_game_button" onclick="jQuery('#idgm_add_game_button').show('fold');jQuery('#idgm_edit_game_dialog').toggle( 'fold' );jQuery('#idgm_edit_game_list').toggle( 'fold' );"><?php _e( "Close", 'indiedev-game-marketer' ); ?></a> <a href="#" class="button-primary" id="idgm-edit-game-form-save-button"><?php _e( "Update Game", 'indiedev-game-marketer' ); ?></a></div>            
            <input type="hidden" name="idgm-delete-game-form-id" id="idgm-delete-game-form-id" value="" />
            <?php            
            echo '<table class="widefat" id="idgm_edit_game_list">';
            $game_results = Indiedev_Game_Marketer_Public::get_games();
            if(isset($game_results[0])) {
                foreach ($game_results as $game) {
                    echo "<tr id='idgm_edit_game_table_id_{$game['id']}'><td style='width:115px;'><a href='#' class='button-secondary' onclick=\"idgmEditGame('".base64_encode(json_encode($game))."');\">" .__( "Edit", 'indiedev-game-marketer' ). "</a> <a href='#' class='button-secondary idgm-delete-game-button' onclick=\"jQuery('#idgm-delete-game-form-id').val({$game['id']});\">" .__( "Delete", 'indiedev-game-marketer' ). "</a></td><td>{$game['id']} - {$game['name']}</td></tr>";
                }
            }
            echo '</table>';
        
        }
        
        public function idgm_twitter_authenticate() {
                        
            require_once (IDGM_PLUGIN_PATH . 'includes/codebird-php-develop/src/codebird.php');

            $options = get_option( 'Indiedev_Game_Marketer_settings' );

            \Codebird\Codebird::setConsumerKey($options['Indiedev_Game_Marketer_select_twitter_consumer_key'], $options['Indiedev_Game_Marketer_select_twitter_consumer_secret']); // static, see README
            $cb = \Codebird\Codebird::getInstance(); 
            $cb->setToken($options['Indiedev_Game_Marketer_select_twitter_token'], $options['Indiedev_Game_Marketer_select_twitter_secret']);
            
            return $cb;
        }
        
        public function idgm_press_release_button_game() {
            global $wpdb;
            $game_id = intval($_POST['id']);

        }        
        
        public function idgm_ajax_press_release_button_game() {
            $ajax_nonce = wp_create_nonce( 'indiedev-game-marketer' );
            ?>
                <script type="text/javascript" >
                
                function idgm_press_release_button_game(option_selected) {
                        
                    var data = {
                            'action': 'idgm_press_release_button_game',
                            'security': '<?php echo $ajax_nonce; ?>',
                            'id': jQuery('#idgm-press_release_button-game-form-id').val()
                    };

                    jQuery("body").css("cursor", "progress");
                    jQuery.post(ajaxurl, data, function(response) {

                        jQuery("body").css("cursor", "default");
                    });
                            
                };
                </script> <?php            
        }
        
        public function idgm_ajax_press_release_button_game_callback() {
            check_ajax_referer( 'indiedev-game-marketer', 'security' );
            $this->idgm_press_release_button_game();
        }        
        
        
        
        public function idgm_create_presskit() {
            global $wpdb;
            
            $game_id = intval($_POST['id']);
            $game_result = Indiedev_Game_Marketer_Public::get_game($game_id, '`name`');
            
            if ($game_result !== null) {
                $id = $this->add_new_page(esc_sql($game_result['name']) .' '. esc_sql(__('Press Kit', 'indiedev-game-marketer')), esc_sql('[indiedev display=presskit game='.$game_id.']'), 0, 'page', 'draft');
                if (0 !== $id) {
                    $wpdb->query("UPDATE `{$wpdb->prefix}idgm_games` SET `page`={$id} WHERE `id`={$game_id};");
                    
                    if(trim($game_result['icon'])!= '') {
                        $upload_dir = wp_upload_dir();
                        $image_name = basename( str_replace ('http:/', '', str_replace ('https:/', '', $game_result['icon'])) );
                        $image_data = file_get_contents($game_result['icon']);
                        $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name );
                        $filename = basename( $unique_file_name );
                        
                        if( wp_mkdir_p( $upload_dir['path'] ) ) {
                            $file = $upload_dir['path'] . '/' . $filename;
                        } else {
                            $file = $upload_dir['basedir'] . '/' . $filename;
                        }

                        file_put_contents( $file, $image_data );
                        $wp_filetype = wp_check_filetype( $filename, null );

                        $attachment = array(
                            'post_mime_type' => $wp_filetype['type'],
                            'post_title'     => sanitize_file_name( $filename ),
                            'post_content'   => '',
                            'post_status'    => 'inherit'
                        );

                        $attach_id = wp_insert_attachment( $attachment, $file, $id );
                        require_once(ABSPATH . 'wp-admin/includes/image.php');
                        $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                        wp_update_attachment_metadata( $attach_id, $attach_data );
                        set_post_thumbnail( $id, $attach_id );                    
                    }
                    echo $id;
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
            exit();
        }
        
        public function idgm_ajax_create_presskit() {
            $ajax_nonce = wp_create_nonce( 'indiedev-game-marketer' );
            ?>
                <script type="text/javascript">
 
                    function idgm_create_presskit_click(game_id) {
                        if (confirm('<?php _e('Are you sure you want to create a press kit for this game?', 'indiedev-game-marketer'); ?>')) {
                            var data = {
                                    'action': 'idgm_create_presskit',
                                    'security': '<?php echo $ajax_nonce; ?>',
                                    'id': game_id
                            };

                            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                            jQuery("body").css("cursor", "progress");
                            jQuery.post(ajaxurl, data, function(response) {
                                jQuery('#idgm-presskit-button-' + game_id).hide('fold');
                                jQuery('#idgm_edit_presskit_table_id_' + game_id).append("<a href='<?php echo admin_url(); ?>post.php?post="+response+"&action=edit' class='button-secondary idgm-edit-presskit-button'><?php _e('Edit Page','indiedev-game-marketer'); ?></a>");
                                jQuery("body").css("cursor", "default");
                            });
                        }
                    }       
                </script> <?php            
        }
        
        public function idgm_ajax_create_presskit_callback() {
            check_ajax_referer( 'indiedev-game-marketer', 'security' );
            $this->idgm_create_presskit();
        }          

        public function idgm_ajax_tinymce() {
            echo '<br /><table class="widefat" style="min-width:816px;max-width:816px;"><tr><td style="border:1px solid;border-color:#DDD;border-bottom:none;"> '.__('Game', 'indiedev-game-marketer').': <select id="idgm-press-release-game-selector">';

            $the_games = Indiedev_Game_Marketer_Public::get_games('`id`, `name`');
            foreach($the_games as $the_game) {
                echo '<option id="idgm-press-release-option-'.$the_game['id'].'" value="'.$the_game['id'].'">'.$the_game['name'].'</option>';
            }
            
            echo '</select> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=small_desc style=none]\');return false;">'.__('Quick Description', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=full_desc style=none]\');return false;">'.__('Full Description', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=home_url style=none]\');return false;">'.__('Home URL', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=page style=none]\');return false;">'.__('Presskit URL', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'<strong>FOR IMMEDIATE RELEASE</strong><br /><br />[indiedev display=name label=false]<br />[indiedev display=phone label=false]<br />[indiedev display=email label=false]<br /><br /><h3>MY ATTENTION GRABBING 75 to 150 WORD HEADLINE</h3><em>The optional sub headline which presents a unique & interesting hook to grab more attention!</em><br /><br /><strong>[indiedev display=location label=false style=inline]</strong> - Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet eleifend arcu. Nullam id tellus eget elit vestibulum lacinia auctor eu nisl. Nulla quis erat bibendum, congue nunc in, pretium orci. Donec eu posuere diam. Donec et laoreet justo. Nulla volutpat maximus ornare. Sed purus quam, finibus quis arcu a, bibendum aliquet felis. Vestibulum est nibh, fermentum vel rhoncus auctor, fermentum sit amet neque. Aliquam non orci eget odio varius feugiat. Praesent lacus ipsum, placerat ut orci at, tempus facilisis libero. Vivamus nec eleifend elit. Donec condimentum elementum vestibulum.<br /><br />Vestibulum nec bibendum mi. Duis a nunc quis leo facilisis aliquet. In non tristique ligula, ut lacinia metus. Mauris bibendum, neque ac volutpat bibendum, sapien metus congue urna, non dapibus magna purus et libero. Cras eu tempus erat. Praesent ultricies vulputate justo in maximus. Aliquam non sagittis mauris. Aliquam nec elit in neque tempus porttitor vitae non quam. Cras nec molestie arcu.<br /><br />Proin dignissim dignissim elementum. Phasellus faucibus vel lacus vitae euismod. Ut ultricies finibus nibh, vel ultricies sapien tempor tempus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas ante lectus, pellentesque ac tellus sit amet, feugiat porttitor felis. Sed rhoncus massa eros, fringilla tempus odio iaculis quis. Phasellus consectetur interdum venenatis. <br /><br /><strong>About [indiedev display=name label=false style=inline]</strong><br />[indiedev display=companydesc label=false]<br /><br />###\');return false;">'.__('Press Release Template', 'indiedev-game-marketer').'</button></td></tr>';
            echo '<tr><td style="border:1px solid;border-color:#DDD;border-bottom:none;border-top:none;"><button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=logo style=none]\');return false;">'.__('Logo', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=icon style=none]\');return false;">'.__('Icon', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=genres style=none]\');return false;">'.__('Genres', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=multiplayer style=none]\');return false;">'.__('Multiplayer', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=game_engine style=none]\');return false;">'.__('Game Engine', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=franchise_series style=none]\');return false;">'.__('Franchise/Series', 'indiedev-game-marketer').'</button></td></tr>';
            echo '<tr><td style="border:1px solid;border-color:#DDD;border-top:none;"><button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=developers style=none]\');return false;">'.__('Developers', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=publishers style=none]\');return false;">'.__('Publishers', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=distributors style=none]\');return false;">'.__('Distributors', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=producers style=none]\');return false;">'.__('Producers', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=designers style=none]\');return false;">'.__('Designers', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=programmers style=none]\');return false;">'.__('Programmers', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=artists style=none]\');return false;">'.__('Artists', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=writers style=none]\');return false;">'.__('Writers', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev game=\'+jQuery(\'#idgm-press-release-game-selector\').val()+\' display=composers style=none]\');return false;">'.__('Composers', 'indiedev-game-marketer').'</button></td></tr>';
            echo '<tr><td> </td></tr>';
            echo '<tr><td style="border:1px solid;border-color:#DDD;">'.__('Company', 'indiedev-game-marketer').': <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=name label=false]\');return false;">'.__('Name', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=companydesc label=false]\');return false;">'.__('Description', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=roles label=false]\');return false;">'.__('Roles', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=email label=false]\');return false;">'.__('Email', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=website label=false]\');return false;">'.__('Website', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=facebook label=false]\');return false;">'.__('Facebook', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=twitter label=false]\');return false;">'.__('Twitter', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=youtube label=false]\');return false;">'.__('YouTube', 'indiedev-game-marketer').'</button> <button class="button-secondary idgm-press_release_button-game-button" onclick="jQuery(\'#idgm-press-release-textarea\').val(jQuery(\'#idgm-press-release-textarea\').val() + \'[indiedev display=phone label=false]\');return false;">'.__('Phone', 'indiedev-game-marketer').'</button></td></tr>';
            echo '<tr><td><textarea style="white-space: pre-wrap;width:100%;height:100px;" id="idgm-press-release-textarea"></textarea></td></tr>';
            echo '</table>';
            exit;
        }            
        
        public function idgm_ajax_tinymce_callback() {
            $this->idgm_ajax_tinymce();
        }           
        
        
        public function idgm_test_twitter() {
            echo __(sprintf('PHP must be 5.5 or higher.  Your version of PHP is %s.' , phpversion() ), 'indiedev-game-marketer'). '<br />';
            if (!extension_loaded('openssl')) {
                _e('No OpenSSL found.  Twitter will not work.', 'indiedev-game-marketer');
            } else {
                _e('Required OpenSSL extension was found.', 'indiedev-game-marketer');
            }
            echo '<br /><br />'; 
            _e(sprintf('Testing your Twitter authentication.  Pulling last 3 tweets from %s@BlackLodgeGames%s.', '<a href="https://twitter.com/BlackLodgeGames">','</a>'), 'indiedev-game-marketer');
            echo '<br /><br />';           
            $cb = $this->idgm_twitter_authenticate();
            $params = array(
                'screen_name' => 'blacklodgegames',
                'count' => 3,
                'include_rts' => false,
            );            
            
            $replies = (array) $cb->statuses_userTimeline($params);
            
            $tweet_count = 0;
            foreach ($replies as $reply) {
                if (trim($reply->id_str) != '') {
                    $tweet_count++;
                    echo '<div class="idgm-tweet" style="display: inline-block; font-family: \'Helvetica Neue\', Roboto, \'Segoe UI\', Calibri, sans-serif;  font-size: 12px;  font-weight: bold;  line-height: 16px;  border-color: #eee #ddd #bbb;  border-radius: 5px;  border-style: solid;  border-width: 1px;box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);margin: 10px 5px;padding: 0 16px 16px 16px;max-width: 468px;    " tweetID="'.$reply->id.'">'.$reply->text.'</div><br /><br />';
                }
            }

            if ($tweet_count < 3) {
                _e('Less than 3 tweets loaded, meaning the test failed.  This means you have either 1) reached your Twitter API call limit, 2) have the wrong values in your Twitter Settings, or 3) do not have have your Twitter App set up correctly.', 'indiedev-game-marketer');
            }
            
            die();
        }        
        
        public function idgm_ajax_test_twitter() {
            $ajax_nonce = wp_create_nonce( 'indiedev-game-marketer' );
            ?>
                <div id="my-twitter-dialog-form" style="display:none;">
                     <div id="my-twitter-dialog-form-contents">
                     </div>
                </div>    
                
                <script type="text/javascript" >
                jQuery(function() {
                    jQuery( "#my-twitter-dialog-form" ).dialog({
                        title: '<?php _e('Testing Your Twitter Settings', 'indiedev-game-marketer'); ?>',
                        autoOpen: false,
                        height: 480,
                        width: 640,
                        modal: true   
                    });
                });
                
                jQuery('.idgm-test-twitter-button').click(function(event) {
                            jQuery("body").css("cursor", "progress");
                            event.preventDefault();
                            var data = {
                                    'action': 'idgm_test_twitter',
                                    'security': '<?php echo $ajax_nonce; ?>'
                            };

                            jQuery.post(ajaxurl, data, function(response) {
                                jQuery("#my-twitter-dialog-form").dialog( "open" );
                                jQuery("#my-twitter-dialog-form-contents").html(response);
                                jQuery("body").css("cursor", "default");
                            });
                        
                });
                </script> 
                
                    <?php            
        }
        
        public function idgm_ajax_test_twitter_callback() {
            check_ajax_referer( 'indiedev-game-marketer', 'security' );
            $this->idgm_test_twitter();
        }          
        
        public function idgm_check_day_for_scheduled_tweet($id, $dayname) {
            if ($dayname === strtolower(date('l'))) {
                $this->idgm_perform_scheduled_tweet($id);
            }
        }
        
        public function idgm_perform_scheduled_tweet($id) {
            global $wpdb;

            $id = intval($id);
            $sql = "SELECT * FROM `{$wpdb->prefix}idgm_tweets` WHERE `id`={$id};";
            $results = $wpdb->get_results($sql, ARRAY_A);                
            $post = '';
            
            if ($results !== null) {
                $cb = $this->idgm_twitter_authenticate();
                $post = substr(do_shortcode($results[0]['post']), 0, 140);
                
                $temp_image_url_array = array();
                if ($results[0]['image1'] != '') {
                    array_push($temp_image_url_array, $results[0]['image1']);
                }
                if ($results[0]['image2'] != '') {
                    array_push($temp_image_url_array, $results[0]['image2']);
                }    
                if ($results[0]['image3'] != '') {
                    array_push($temp_image_url_array, $results[0]['image3']);
                }    
                if ($results[0]['image4'] != '') {
                    array_push($temp_image_url_array, $results[0]['image4']);
                }          
                
                if(@isset($temp_image_url_array[0])) {
                    $media_files = $temp_image_url_array;
                    $media_ids = array();
                    
                    foreach ($media_files as $file) {
                      $reply = $cb->media_upload([
                        'media' => $file
                      ]);
                      $media_ids[] = $reply->media_id_string;
                    }    
                    $media_ids = implode(',', $media_ids);
                    $params = [
                      'status' => $post,
                      'media_ids' => $media_ids
                    ];                    
                } else {
                    $params = [
                      'status' => $post
                    ];                    
                }

                $reply = $cb->statuses_update($params); 
                $status = $reply->httpstatus;
                if($status == 200) {                
                    if($results[0]['post_frequency']==='once' || $results[0]['post_frequency']==='now') {
                        $sql = "UPDATE `{$wpdb->prefix}idgm_tweets` SET `status`='published' WHERE `id`={$id}; ";
                        $results = $wpdb->query($sql);                    
                    }
                } else {
                        $sql = "UPDATE `{$wpdb->prefix}idgm_tweets` SET `status`='error' WHERE `id`={$id}; ";
                        $results = $wpdb->query($sql);                               
                }
            }            
        }
        
        public function idgm_schedule_tweet() {
            global $wpdb;
            if ($_POST['post_frequency']==='now') {
                $_POST['post_date_time'] = 'now';
            }
            $cleaned_date_time = esc_sql(strtotime($_POST['post_date_time']));
            $sql = "INSERT INTO `{$wpdb->prefix}idgm_tweets` (`id`, `post`, `image1`, `image2`, `image3`, `image4`, `post_frequency`, `post_date_time`, `auto_attach`, `status`) VALUES ('', '".esc_sql($_POST['post'])."', '".esc_sql($_POST['image1'])."', '".esc_sql($_POST['image2'])."', '".esc_sql($_POST['image3'])."', '".esc_sql($_POST['image4'])."', '".esc_sql($_POST['post_frequency'])."', '".$cleaned_date_time."', '".esc_sql($_POST['auto_attach'])."', 'pending');";
            $results = $wpdb->query($sql);
            if($results===false) {
                // ERROR
            } else { // If we get this far, we are still successful					
                echo $wpdb->insert_id;
                if ($_POST['post_frequency']==='now') {
                    $this->idgm_perform_scheduled_tweet($wpdb->insert_id);
                } else if ($_POST['post_frequency']==='once') {
                    add_action( 'idgm-scheduled-tweet-action-'.$wpdb->insert_id, array( $this, 'idgm_perform_scheduled_tweet' ), 10, 1 );
                    wp_schedule_single_event( $cleaned_date_time, 'idgm-scheduled-tweet-action-'.$wpdb->insert_id, array( $wpdb->insert_id ) );
                } else if ($_POST['post_frequency']==='daily') {
                    add_action( 'idgm-scheduled-tweet-action-'.$wpdb->insert_id, array( $this, 'idgm_perform_scheduled_tweet' ), 10, 1 );
                    wp_schedule_event( $cleaned_date_time, 'daily' , 'idgm-scheduled-tweet-action-'.$wpdb->insert_id, array( $wpdb->insert_id ) );                    
                } else if ($_POST['post_frequency']==='monday' || $_POST['post_frequency']==='tuesday' || $_POST['post_frequency']==='wednesday' || $_POST['post_frequency']==='thursday' ||  $_POST['post_frequency']==='friday' || $_POST['post_frequency']==='saturday' || $_POST['post_frequency']==='sunday') {
                    add_action( 'idgm-scheduled-tweet-action-'.$wpdb->insert_id, array( $this, 'idgm_check_day_for_scheduled_tweet' ), 10, 2 );
                    wp_schedule_event( $cleaned_date_time, 'daily' , 'idgm-scheduled-tweet-action-'.$wpdb->insert_id, array( $wpdb->insert_id, $_POST['post_frequency'] ) );                     
                } 
            }  
            exit();            
        }        
        
        public function idgm_ajax_schedule_tweet() {
            $ajax_nonce = wp_create_nonce( 'indiedev-game-marketer' );
            ?>
                <script type="text/javascript" >
                
                jQuery(document).on( 'click', '.idgm-tweet-button', function() {
                        if (jQuery('#idgm-tweet-box').val().length > 140) {
                            alert('<?php _e('You cannot post a tweet that has more than 140 characters.  Please revise your tweet and try again.', 'indiedev-game-marketer'); ?>')
                        } else {
                            var post_frequency = '';
                            if (jQuery('#idgm-twitter-select').val()=== 'once' || jQuery('#idgm-twitter-select').val()=== 'now') {
                                post_frequency = jQuery('#idgm-twitter-select').val();
                            } else {
                                post_frequency = jQuery('#idgm-tweet-weekly-day').val();
                            }
                            var data = {
                                    'action': 'idgm_schedule_tweet',
                                    'security': '<?php echo $ajax_nonce; ?>',
                                    'post': jQuery('#idgm-tweet-box').val(),
                                    'image1': jQuery('#idgm_tweet-image1').val(),
                                    'image2': jQuery('#idgm_tweet-image2').val(),
                                    'image3': jQuery('#idgm_tweet-image3').val(),
                                    'image4': jQuery('#idgm_tweet-image4').val(),
                                    'post_frequency': post_frequency,
                                    'post_date_time': jQuery('#idgm-tweet-time').val() + " " + jQuery('#idgm-tweet-date').val(),
                                    'auto_attach' : jQuery('#idgm-tweet-auto-attach').val()
                            };

                            jQuery("body").css("cursor", "progress");
                            jQuery.post(ajaxurl, data, function(response) {
                                jQuery('#idgm-tweet-box').val('');
                                jQuery('#idgm_tweet-image1').val('');
                                jQuery('#idgm_tweet-image2').val('');
                                jQuery('#idgm_tweet-image3').val('');
                                jQuery('#idgm_tweet-image4').val('');
                                jQuery('#idgm-twitter-images').html('');
                                jQuery("body").css("cursor", "default");
                            });
                        }
                });
                </script> <?php            
        }
        
        public function idgm_ajax_schedule_tweet_callback() {
            check_ajax_referer( 'indiedev-game-marketer', 'security' );
            $this->idgm_schedule_tweet();
        }          
        
        
        
        public function idgm_show_scheduled_tweets() {
            global $wpdb;
            $sql = "SELECT * FROM `{$wpdb->prefix}idgm_tweets` WHERE `status`='pending' ORDER BY `post_date_time`;";
            $results = $wpdb->get_results($sql, ARRAY_A);
            if (isset($results[0])){
                echo '<center><h4>'.__('Scheduled Tweets', 'indiedev-game-marketer').'</h4></center>';
                echo '<input type="hidden" val="0" id="idgm-tweet-id-to-delete" />';
                foreach ($results as $result) {
                    echo '<table class="widefat" id="idgm-scheduled-tweet-table-'.$result['id'].'" style="margin-top:10px;width:100%;border:1px solid #DDDDDD;background-color:#EEEEEE;" id="idgm-scheduled-tweets-table">';
                    echo '<tr><td>'.$result['post'] . '<br style="clear:both;" />';
                    if ($result['image1']!='') { echo '<img src="'.$result['image1'].'" style="width:50px;height:50px;object-fit: cover;object-position: center;float:left;margin:5px;" />'; }
                    if ($result['image2']!='') { echo '<img src="'.$result['image2'].'" style="width:50px;height:50px;object-fit: cover;object-position: center;float:left;margin:5px;" />'; }
                    if ($result['image3']!='') { echo '<img src="'.$result['image3'].'" style="width:50px;height:50px;object-fit: cover;object-position: center;float:left;margin:5px;" />'; }
                    if ($result['image4']!='') { echo '<img src="'.$result['image4'].'" style="width:50px;height:50px;object-fit: cover;object-position: center;float:left;margin:5px;" />'; }
                    echo '</td></tr>';
                    echo '<tr><td>? <strong>'.$result['post_frequency'].'</strong> <em>'. date('D, d M Y H:i:s', $result['post_date_time']) .'</em><a href="#" class="button-secondary" style="float:right;" onclick="jQuery(\'#idgm-tweet-id-to-delete\').val('.$result['id'].');">'.__('Delete', 'indiedev-game-marketer').'</a></td></tr>';
                    echo '</table>';
                }
            }
        }        
        
        public function idgm_ajax_show_scheduled_tweets() {
            $ajax_nonce = wp_create_nonce( 'indiedev-game-marketer' );
            ?>
                <script type="text/javascript" >
                
                function idgm_update_tweets_list() {

                            var data = {
                                    'action': 'idgm_show_scheduled_tweets',
                                    'security': '<?php echo $ajax_nonce; ?>'
                            };

                            jQuery("body").css("cursor", "progress");
                            jQuery.post(ajaxurl, data, function(response) {
                                jQuery('#idgm-tweets-list').html(response);
                                jQuery("body").css("cursor", "default");
                            });
                        
                };
                </script> <?php            
        }
        
        public function idgm_ajax_show_scheduled_tweets_callback() {
            check_ajax_referer( 'indiedev-game-marketer', 'security' );
            $this->idgm_show_scheduled_tweets();
        }         
        
        
        
        public function idgm_delete_game() {
            global $wpdb;
            $game_id = intval($_POST['id']);
            $sql = "DELETE FROM `{$wpdb->prefix}idgm_games` WHERE `id`={$game_id};";
            $wpdb->query($sql);
        }        
        
        public function idgm_ajax_delete_game() {
            $ajax_nonce = wp_create_nonce( 'indiedev-game-marketer' );
            ?>
                <script type="text/javascript" >
                
                jQuery(document).on( 'click', '.idgm-delete-game-button', function() {
                        if (confirm('<?php _e('Are you sure you want to delete this game? This action cannot be reversed!', 'indiedev-game-marketer'); ?>')) {
                            var data = {
                                    'action': 'idgm_delete_game',
                                    'security': '<?php echo $ajax_nonce; ?>',
                                    'id': jQuery('#idgm-delete-game-form-id').val()
                            };

                            jQuery("body").css("cursor", "progress");
                            jQuery.post(ajaxurl, data, function(response) {
                                jQuery('#idgm_edit_game_table_id_' + jQuery('#idgm-delete-game-form-id').val()).hide('fold');
                                jQuery('#idgm_edit_presskit_table_row_' + jQuery('#idgm-delete-game-form-id').val()).hide('fold');
                                jQuery('#idgm-press-release-option-' + jQuery('#idgm-delete-game-form-id').val()).hide('fold');
                                jQuery('#idgm-press-release-game-selector').prop('selectedIndex', 0);
                                jQuery("body").css("cursor", "default");
                            });
                        }
                });
                </script> <?php            
        }
        
        public function idgm_ajax_delete_game_callback() {
            check_ajax_referer( 'indiedev-game-marketer', 'security' );
            $this->idgm_delete_game();
        }        
        
        public function idgm_save_game($db_input) {
            global $wpdb;
            $sql = "INSERT INTO `{$wpdb->prefix}idgm_games` (`id`, `name`, `logo`, `icon`, `small_desc`, `long_desc`, `genres`, `multiplayer`, `home_url`, `developers`, `publishers`, `distributors`, `producers`, `designers`, `programmers`, `artists`, `writers`, `composers`, `game_engine`, `franchise_series`, `platform_a`, `release_date_a`, `platform_b`, `release_date_b`, `platform_c`, `release_date_c`, `platform_d`, `release_date_d`, `platform_e`, `release_date_e`, `platform_f`, `release_date_f`, `platform_g`, `release_date_g`, `platform_h`, `release_date_h`, `platform_i`, `release_date_i`, `platform_j`, `release_date_j`, `page`) VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', 0);";
            $results = $wpdb->query($wpdb->prepare($sql, $db_input['name'], $db_input['logo'], $db_input['icon'], $db_input['small_desc'], $db_input['long_desc'], $db_input['genres'], $db_input['multiplayer'], $db_input['home_url'], $db_input['developers'], $db_input['publishers'], $db_input['distributors'], $db_input['producers'], $db_input['designers'], $db_input['programmers'], $db_input['artists'], $db_input['writers'], $db_input['composers'], $db_input['game_engine'], $db_input['franchise_series'], $db_input['platform_a'], $db_input['release_date_a'], $db_input['platform_b'], $db_input['release_date_b'], $db_input['platform_c'], $db_input['release_date_c'], $db_input['platform_d'], $db_input['release_date_d'], $db_input['platform_e'], $db_input['release_date_e'], $db_input['platform_f'], $db_input['release_date_f'], $db_input['platform_g'], $db_input['release_date_g'], $db_input['platform_h'], $db_input['release_date_h'], $db_input['platform_i'], $db_input['release_date_i'], $db_input['platform_j'], $db_input['release_date_j']));
            if($results===false) {
                // ERROR
            } else { // If we get this far, we are still successful					
                echo $wpdb->insert_id;
            }  
            exit();
        }
        
        public function idgm_ajax_save_game() { 
            $ajax_nonce = wp_create_nonce( 'indiedev-game-marketer' );
            ?>
            <script type="text/javascript" >
                function js_base64_encode (stringToEncode) { // eslint-disable-line camelcase
                  //  discuss at: http://locutus.io/php/base64_encode/
                  // original by: Tyler Akins (http://rumkin.com)
                  // improved by: Bayron Guevara
                  // improved by: Thunder.m
                  // improved by: Kevin van Zonneveld (http://kvz.io)
                  // improved by: Kevin van Zonneveld (http://kvz.io)
                  // improved by: Rafał Kukawski (http://blog.kukawski.pl)
                  // bugfixed by: Pellentesque Malesuada
                  //   example 1: base64_encode('Kevin van Zonneveld')
                  //   returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
                  //   example 2: base64_encode('a')
                  //   returns 2: 'YQ=='
                  //   example 3: base64_encode('✓ à la mode')
                  //   returns 3: '4pyTIMOgIGxhIG1vZGU='

                  if (typeof window !== 'undefined') {
                    if (typeof window.btoa !== 'undefined') {
                      return window.btoa(unescape(encodeURIComponent(stringToEncode)))
                    }
                  } else {
                    return new Buffer(stringToEncode).toString('base64')
                  }

                  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
                  var o1
                  var o2
                  var o3
                  var h1
                  var h2
                  var h3
                  var h4
                  var bits
                  var i = 0
                  var ac = 0
                  var enc = ''
                  var tmpArr = []

                  if (!stringToEncode) {
                    return stringToEncode
                  }

                  stringToEncode = unescape(encodeURIComponent(stringToEncode))

                  do {
                    // pack three octets into four hexets
                    o1 = stringToEncode.charCodeAt(i++)
                    o2 = stringToEncode.charCodeAt(i++)
                    o3 = stringToEncode.charCodeAt(i++)

                    bits = o1 << 16 | o2 << 8 | o3

                    h1 = bits >> 18 & 0x3f
                    h2 = bits >> 12 & 0x3f
                    h3 = bits >> 6 & 0x3f
                    h4 = bits & 0x3f

                    // use hexets to index into b64, and append result to encoded string
                    tmpArr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4)
                  } while (i < stringToEncode.length)

                  enc = tmpArr.join('')

                  var r = stringToEncode.length % 3

                  return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3)
                }                     
                
                jQuery(document).on( 'click', '#idgm-new-game-form-save-button', function() {
                        jQuery("body").css("cursor", "progress");
                        var data = {
                                'action': 'idgm_save_new_game',
                                'security': '<?php echo $ajax_nonce; ?>',
                                'name': jQuery('#idgm-new-game-form-name').val(),
                                'logo': jQuery('#idgm-new-game-form-logo').val(),
                                'icon': jQuery('#idgm-new-game-form-icon').val(),
                                'small_desc': jQuery('#idgm-new-game-form-small-desc').val(),
                                'long_desc': jQuery('#idgm-new-game-form-long-desc').val(),
                                'genres': jQuery('#idgm-new-game-form-genres').val(),
                                'multiplayer': jQuery('#idgm-new-game-form-multiplayer').val(),
                                'home_url': jQuery('#idgm-new-game-form-home-url').val(),
                                'developers': jQuery('#idgm-new-game-form-developers').val(),
                                'publishers': jQuery('#idgm-new-game-form-publishers').val(),
                                'distributors': jQuery('#idgm-new-game-form-distributors').val(),
                                'producers': jQuery('#idgm-new-game-form-producers').val(),
                                'designers': jQuery('#idgm-new-game-form-designers').val(),
                                'programmers': jQuery('#idgm-new-game-form-programmers').val(),
                                'artists': jQuery('#idgm-new-game-form-artists').val(),
                                'writers': jQuery('#idgm-new-game-form-writers').val(),
                                'composers': jQuery('#idgm-new-game-form-composers').val(),
                                'game_engine': jQuery('#idgm-new-game-form-game-engine').val(),
                                'franchise_series': jQuery('#idgm-new-game-form-franchise-series').val(),
                                'platform_a': jQuery('#idgm-new-game-form-platform-a').val(),
                                'release_date_a': jQuery('#idgm-new-game-form-release-date-a').val(),
                                'platform_b': jQuery('#idgm-new-game-form-platform-b').val(),
                                'release_date_b': jQuery('#idgm-new-game-form-release-date-b').val(),
                                'platform_c': jQuery('#idgm-new-game-form-platform-c').val(),
                                'release_date_c': jQuery('#idgm-new-game-form-release-date-c').val(),
                                'platform_d': jQuery('#idgm-new-game-form-platform-d').val(),
                                'release_date_d': jQuery('#idgm-new-game-form-release-date-d').val(),
                                'platform_e': jQuery('#idgm-new-game-form-platform-e').val(),
                                'release_date_e': jQuery('#idgm-new-game-form-release-date-e').val(),
                                'platform_f': jQuery('#idgm-new-game-form-platform-f').val(),
                                'release_date_f': jQuery('#idgm-new-game-form-release-date-f').val(),
                                'platform_g': jQuery('#idgm-new-game-form-platform-g').val(),
                                'release_date_g': jQuery('#idgm-new-game-form-release-date-g').val(),
                                'platform_h': jQuery('#idgm-new-game-form-platform-h').val(),
                                'release_date_h': jQuery('#idgm-new-game-form-release-date-h').val(),
                                'platform_i': jQuery('#idgm-new-game-form-platform-i').val(),
                                'release_date_i': jQuery('#idgm-new-game-form-release-date-i').val(),
                                'platform_j': jQuery('#idgm-new-game-form-platform-j').val(),
                                'release_date_j': jQuery('#idgm-new-game-form-release-date-j').val(),
                                'greenlight_url': jQuery('#idgm-new-game-form-greenlight-url').val(),
                                'release_a_url': jQuery('#idgm-new-game-form-release-a-url').val(),
                                'release_b_url': jQuery('#idgm-new-game-form-release-b-url').val(),
                                'release_c_url': jQuery('#idgm-new-game-form-release-c-url').val(),
                                'release_d_url': jQuery('#idgm-new-game-form-release-d-url').val(),
                                'release_e_url': jQuery('#idgm-new-game-form-release-e-url').val(),
                                'release_f_url': jQuery('#idgm-new-game-form-release-f-url').val(),
                                'release_g_url': jQuery('#idgm-new-game-form-release-g-url').val(),
                                'release_h_url': jQuery('#idgm-new-game-form-release-h-url').val(),
                                'release_i_url': jQuery('#idgm-new-game-form-release-i-url').val(),
                                'release_j_url': jQuery('#idgm-new-game-form-release-j-url').val()
                        };

                        jQuery.post(ajaxurl, data, function(response) {
                                jQuery.extend(data, {'id':response});
                                idgm_edit_data = js_base64_encode(JSON.stringify(data));
                                jQuery("#idgm_edit_game_list").append("<tr id='idgm_edit_game_table_id_"+response+"'><td style='width:115px;'><a href='#' class='button-secondary' onclick=\"idgmEditGame('"+idgm_edit_data+"');\"><?php _e( "Edit", 'indiedev-game-marketer' ); ?></a> <a href='#' class='button-secondary idgm-delete-game-button' onclick=\"jQuery('#idgm-delete-game-form-id').val("+response+");\"><?php _e( "Delete", 'indiedev-game-marketer' ) ?></a></td><td>"+response+" - "+jQuery('#idgm-new-game-form-name').val()+"</td></tr>");
                                jQuery("#idgm_edit_presskit_list").append("<tr id='idgm_edit_presskit_table_row_"+response+"'><td style='width:115px;' id='idgm_edit_presskit_table_id_"+response+"'><a href='#' class='button-secondary idgm-create-presskit-button' id='idgm-presskit-button-"+response+"' onclick='idgm_create_presskit_click("+response+");'><?php _e( "Create Page", 'indiedev-game-marketer' ); ?></a></td><td>"+jQuery('#idgm-new-game-form-name').val()+"</td></tr>");
                                jQuery("#idgm-press-release-game-selector").append("<option id='idgm-press-release-option-"+response+"' value='"+response+"'>"+ jQuery('#idgm-new-game-form-name').val()+"</option>");
                                jQuery('#idgm_add_game_dialog').hide('fold');
                                jQuery('#idgm_add_game_button').show('fold');  
                                jQuery('#idgm-new-game-form-name').val('');
                                jQuery('#idgm-new-game-form-logo').val('');
                                jQuery('#idgm-new-game-form-icon').val('');
                                jQuery('#idgm-new-game-form-small-desc').val('');
                                jQuery('#idgm-new-game-form-long-desc').val('');
                                jQuery('#idgm-new-game-form-genres').val('');
                                jQuery('#idgm-new-game-form-multiplayer').val('');
                                jQuery('#idgm-new-game-form-home-url').val('');
                                jQuery('#idgm-new-game-form-developers').val('');
                                jQuery('#idgm-new-game-form-publishers').val('');
                                jQuery('#idgm-new-game-form-distributors').val('');
                                jQuery('#idgm-new-game-form-producers').val('');
                                jQuery('#idgm-new-game-form-designers').val('');
                                jQuery('#idgm-new-game-form-programmers').val('');
                                jQuery('#idgm-new-game-form-artists').val('');
                                jQuery('#idgm-new-game-form-writers').val('');
                                jQuery('#idgm-new-game-form-composers').val('');
                                jQuery('#idgm-new-game-form-game-engine').val('');
                                jQuery('#idgm-new-game-form-franchise-series').val('');
                                jQuery('#idgm-new-game-form-platform-a').val('');
                                jQuery('#idgm-new-game-form-release-date-a').val('');
                                jQuery('#idgm-new-game-form-platform-b').val('');
                                jQuery('#idgm-new-game-form-release-date-b').val('');
                                jQuery('#idgm-new-game-form-platform-c').val('');
                                jQuery('#idgm-new-game-form-release-date-c').val('');
                                jQuery('#idgm-new-game-form-platform-d').val('');
                                jQuery('#idgm-new-game-form-release-date-d').val('');
                                jQuery('#idgm-new-game-form-platform-e').val('');
                                jQuery('#idgm-new-game-form-release-date-e').val('');
                                jQuery('#idgm-new-game-form-platform-f').val('');
                                jQuery('#idgm-new-game-form-release-date-f').val('');
                                jQuery('#idgm-new-game-form-platform-g').val('');
                                jQuery('#idgm-new-game-form-release-date-g').val('');
                                jQuery('#idgm-new-game-form-platform-h').val('');
                                jQuery('#idgm-new-game-form-release-date-h').val('');
                                jQuery('#idgm-new-game-form-platform-i').val('');
                                jQuery('#idgm-new-game-form-release-date-i').val('');
                                jQuery('#idgm-new-game-form-platform-j').val('');
                                jQuery('#idgm-new-game-form-release-date-j').val('');
                                jQuery('#idgm-new-game-form-greenlight-url').val('');
                                jQuery('#idgm-new-game-form-release-a-url').val('');
                                jQuery('#idgm-new-game-form-release-b-url').val('');
                                jQuery('#idgm-new-game-form-release-c-url').val('');
                                jQuery('#idgm-new-game-form-release-d-url').val('');
                                jQuery('#idgm-new-game-form-release-e-url').val('');
                                jQuery('#idgm-new-game-form-release-f-url').val('');
                                jQuery('#idgm-new-game-form-release-g-url').val('');
                                jQuery('#idgm-new-game-form-release-h-url').val('');
                                jQuery('#idgm-new-game-form-release-i-url').val('');
                                jQuery('#idgm-new-game-form-release-j-url').val('');                                
                                jQuery('html, body').animate({ scrollTop: 0 }, 'fast');
                                jQuery("body").css("cursor", "default");
                        });
                });
                </script> <?php
        }        
        
        public function idgm_ajax_save_game_callback() {
            $idgmallowedposttags = $this->idgm_allowed_html();     
                        
            check_ajax_referer( 'indiedev-game-marketer', 'security' );
            $db_input['name'] = sanitize_text_field($_POST['name']);
            $db_input['logo'] = sanitize_text_field($_POST['logo']);
            $db_input['icon'] = sanitize_text_field($_POST['icon']);
            $db_input['small_desc'] = stripslashes(wp_kses($_POST['small_desc'], $idgmallowedposttags));
            $db_input['long_desc'] = stripslashes(wp_kses($_POST['long_desc'], $idgmallowedposttags));
            $db_input['genres'] = sanitize_text_field($_POST['genres']);
            $db_input['multiplayer'] = sanitize_text_field($_POST['multiplayer']);
            $db_input['home_url'] = sanitize_text_field($_POST['home_url']);
            $db_input['developers'] = sanitize_text_field($_POST['developers']);
            $db_input['publishers'] = sanitize_text_field($_POST['publishers']);
            $db_input['distributors'] = sanitize_text_field($_POST['distributors']);
            $db_input['producers'] = sanitize_text_field($_POST['producers']);
            $db_input['designers'] = sanitize_text_field($_POST['designers']);
            $db_input['programmers'] = sanitize_text_field($_POST['programmers']);
            $db_input['artists'] = sanitize_text_field($_POST['artists']);
            $db_input['writers'] = sanitize_text_field($_POST['writers']);
            $db_input['composers'] = sanitize_text_field($_POST['composers']);
            $db_input['game_engine'] = sanitize_text_field($_POST['game_engine']);
            $db_input['franchise_series'] = sanitize_text_field($_POST['franchise_series']);
            $db_input['platform_a'] = sanitize_text_field($_POST['platform_a']);
            $db_input['release_date_a'] = sanitize_text_field($_POST['release_date_a']);
            $db_input['platform_b'] = sanitize_text_field($_POST['platform_b']);
            $db_input['release_date_b'] = sanitize_text_field($_POST['release_date_b']);
            $db_input['platform_c'] = sanitize_text_field($_POST['platform_c']);
            $db_input['release_date_c'] = sanitize_text_field($_POST['release_date_c']);
            $db_input['platform_d'] = sanitize_text_field($_POST['platform_d']);
            $db_input['release_date_d'] = sanitize_text_field($_POST['release_date_d']);
            $db_input['platform_e'] = sanitize_text_field($_POST['platform_e']);
            $db_input['release_date_e'] = sanitize_text_field($_POST['release_date_e']);
            $db_input['platform_f'] = sanitize_text_field($_POST['platform_f']);
            $db_input['release_date_f'] = sanitize_text_field($_POST['release_date_f']);
            $db_input['platform_g'] = sanitize_text_field($_POST['platform_g']);
            $db_input['release_date_g'] = sanitize_text_field($_POST['release_date_g']);
            $db_input['platform_h'] = sanitize_text_field($_POST['platform_h']);
            $db_input['release_date_h'] = sanitize_text_field($_POST['release_date_h']);
            $db_input['platform_i'] = sanitize_text_field($_POST['platform_i']);
            $db_input['release_date_i'] = sanitize_text_field($_POST['release_date_i']);            
            $db_input['platform_j'] = sanitize_text_field($_POST['platform_j']);
            $db_input['release_date_j'] = sanitize_text_field($_POST['release_date_j']);
            $db_input['greenlight_url'] = sanitize_text_field($_POST['greenlight_url']);
            $db_input['release_a_url'] = sanitize_text_field($_POST['release_a_url']);
            $db_input['release_b_url'] = sanitize_text_field($_POST['release_b_url']);
            $db_input['release_c_url'] = sanitize_text_field($_POST['release_c_url']);
            $db_input['release_d_url'] = sanitize_text_field($_POST['release_d_url']);
            $db_input['release_e_url'] = sanitize_text_field($_POST['release_e_url']);
            $db_input['release_f_url'] = sanitize_text_field($_POST['release_f_url']);
            $db_input['release_g_url'] = sanitize_text_field($_POST['release_g_url']);
            $db_input['release_h_url'] = sanitize_text_field($_POST['release_h_url']);
            $db_input['release_i_url'] = sanitize_text_field($_POST['release_i_url']);
            $db_input['release_j_url'] = sanitize_text_field($_POST['release_j_url']);
            
            $this->idgm_save_game($db_input);
        }
                
        
        public function idgm_edit_game($db_input) {
            global $wpdb;
            $sql = "UPDATE `{$wpdb->prefix}idgm_games` SET `name`='%s', `logo`='%s', `icon`='%s', `small_desc`='%s', `long_desc`='%s', `genres`='%s', `multiplayer`='%s', `home_url`='%s', `developers`='%s', `publishers`='%s', `distributors`='%s', `producers`='%s', `designers`='%s', `programmers`='%s', `artists`='%s', `writers`='%s', `composers`='%s', `game_engine`='%s', `franchise_series`='%s', `platform_a`='%s', `release_date_a`='%s', `platform_b`='%s', `release_date_b`='%s', `platform_c`='%s', `release_date_c`='%s', `platform_d`='%s', `release_date_d`='%s', `platform_e`='%s', `release_date_e`='%s', `platform_f`='%s', `release_date_f`='%s', `platform_g`='%s', `release_date_g`='%s', `platform_h`='%s', `release_date_h`='%s', `platform_i`='%s', `release_date_i`='%s', `platform_j`='%s', `release_date_j`='%s', `greenlight_url`='%s', `release_a_url`='%s', `release_b_url`='%s', `release_c_url`='%s', `release_d_url`='%s', `release_e_url`='%s', `release_f_url`='%s', `release_g_url`='%s', `release_h_url`='%s', `release_i_url`='%s', `release_j_url`='%s' WHERE `id`={$db_input['id']};";
            $results = $wpdb->query($wpdb->prepare($sql, $db_input['name'], $db_input['logo'], $db_input['icon'], $db_input['small_desc'], $db_input['long_desc'], $db_input['genres'], $db_input['multiplayer'], $db_input['home_url'], $db_input['developers'], $db_input['publishers'], $db_input['distributors'], $db_input['producers'], $db_input['designers'], $db_input['programmers'], $db_input['artists'], $db_input['writers'], $db_input['composers'], $db_input['game_engine'], $db_input['franchise_series'], $db_input['platform_a'], $db_input['release_date_a'], $db_input['platform_b'], $db_input['release_date_b'], $db_input['platform_c'], $db_input['release_date_c'], $db_input['platform_d'], $db_input['release_date_d'], $db_input['platform_e'], $db_input['release_date_e'], $db_input['platform_f'], $db_input['release_date_f'], $db_input['platform_g'], $db_input['release_date_g'], $db_input['platform_h'], $db_input['release_date_h'], $db_input['platform_i'], $db_input['release_date_i'], $db_input['platform_j'], $db_input['release_date_j'], $db_input['greenlight_url'], $db_input['release_a_url'], $db_input['release_b_url'], $db_input['release_c_url'], $db_input['release_d_url'], $db_input['release_e_url'], $db_input['release_f_url'], $db_input['release_g_url'], $db_input['release_h_url'], $db_input['release_i_url'], $db_input['release_j_url']));
            if($results===false) {
                // ERROR
            } else { // If we get this far, we are still successful					
                echo $wpdb->insert_id;
            }  
            exit();
        }
        
        public function idgm_ajax_edit_game() { 
            $ajax_nonce = wp_create_nonce( 'indiedev-game-marketer' );
            ?>
            <script type="text/javascript" >                   
                
                jQuery(document).on( 'click', '#idgm-edit-game-form-save-button', function() {
                        jQuery("body").css("cursor", "progress");
                        var data = {
                                'action': 'idgm_edit_game',
                                'security': '<?php echo $ajax_nonce; ?>',
                                'id': jQuery('#idgm-edit-game-form-id').val(),
                                'name': jQuery('#idgm-edit-game-form-name').val(),
                                'logo': jQuery('#idgm-edit-game-form-logo').val(),
                                'icon': jQuery('#idgm-edit-game-form-icon').val(),
                                'small_desc': jQuery('#idgm-edit-game-form-small-desc').val(),
                                'long_desc': jQuery('#idgm-edit-game-form-long-desc').val(),
                                'genres': jQuery('#idgm-edit-game-form-genres').val(),
                                'multiplayer': jQuery('#idgm-edit-game-form-multiplayer').val(),
                                'home_url': jQuery('#idgm-edit-game-form-home-url').val(),
                                'developers': jQuery('#idgm-edit-game-form-developers').val(),
                                'publishers': jQuery('#idgm-edit-game-form-publishers').val(),
                                'distributors': jQuery('#idgm-edit-game-form-distributors').val(),
                                'producers': jQuery('#idgm-edit-game-form-producers').val(),
                                'designers': jQuery('#idgm-edit-game-form-designers').val(),
                                'programmers': jQuery('#idgm-edit-game-form-programmers').val(),
                                'artists': jQuery('#idgm-edit-game-form-artists').val(),
                                'writers': jQuery('#idgm-edit-game-form-writers').val(),
                                'composers': jQuery('#idgm-edit-game-form-composers').val(),
                                'game_engine': jQuery('#idgm-edit-game-engine').val(),
                                'franchise_series': jQuery('#idgm-edit-game-form-franchise-series').val(),
                                'platform_a': jQuery('#idgm-edit-game-form-platform-a').val(),
                                'release_date_a': jQuery('#idgm-edit-game-form-release-date-a').val(),
                                'platform_b': jQuery('#idgm-edit-game-form-platform-b').val(),
                                'release_date_b': jQuery('#idgm-edit-game-form-release-date-b').val(),
                                'platform_c': jQuery('#idgm-edit-game-form-platform-c').val(),
                                'release_date_c': jQuery('#idgm-edit-game-form-release-date-c').val(),
                                'platform_d': jQuery('#idgm-edit-game-form-platform-d').val(),
                                'release_date_d': jQuery('#idgm-edit-game-form-release-date-d').val(),
                                'platform_e': jQuery('#idgm-edit-game-form-platform-e').val(),
                                'release_date_e': jQuery('#idgm-edit-game-form-release-date-e').val(),
                                'platform_f': jQuery('#idgm-edit-game-form-platform-f').val(),
                                'release_date_f': jQuery('#idgm-edit-game-form-release-date-f').val(),
                                'platform_g': jQuery('#idgm-edit-game-form-platform-g').val(),
                                'release_date_g': jQuery('#idgm-edit-game-form-release-date-g').val(),
                                'platform_h': jQuery('#idgm-edit-game-form-platform-h').val(),
                                'release_date_h': jQuery('#idgm-edit-game-form-release-date-h').val(),
                                'platform_i': jQuery('#idgm-edit-game-form-platform-i').val(),
                                'release_date_i': jQuery('#idgm-edit-game-form-release-date-i').val(),
                                'platform_j': jQuery('#idgm-edit-game-form-platform-j').val(),
                                'release_date_j': jQuery('#idgm-edit-game-form-release-date-j').val(),
                                'greenlight_url': jQuery('#idgm-edit-game-form-greenlight-url').val(),
                                'release_a_url': jQuery('#idgm-edit-game-form-release-a-url').val(),
                                'release_b_url': jQuery('#idgm-edit-game-form-release-b-url').val(),
                                'release_c_url': jQuery('#idgm-edit-game-form-release-c-url').val(),
                                'release_d_url': jQuery('#idgm-edit-game-form-release-d-url').val(),
                                'release_e_url': jQuery('#idgm-edit-game-form-release-e-url').val(),
                                'release_f_url': jQuery('#idgm-edit-game-form-release-f-url').val(),
                                'release_g_url': jQuery('#idgm-edit-game-form-release-g-url').val(),
                                'release_h_url': jQuery('#idgm-edit-game-form-release-h-url').val(),
                                'release_i_url': jQuery('#idgm-edit-game-form-release-i-url').val(),
                                'release_j_url': jQuery('#idgm-edit-game-form-release-j-url').val()
                        };

                        jQuery.post(ajaxurl, data, function(response) {
                                idgm_edit_data = js_base64_encode(JSON.stringify(data));
                                jQuery("#idgm_edit_game_table_id_"+jQuery('#idgm-edit-game-form-id').val()).remove();
                                jQuery("#idgm_edit_game_list").append("<tr id='idgm_edit_game_table_id_"+jQuery('#idgm-edit-game-form-id').val()+"'><td style='width:115px;'><a href='#' class='button-secondary' onclick=\"idgmEditGame('"+idgm_edit_data+"');\"><?php _e( "Edit", 'indiedev-game-marketer' ); ?></a> <a href='#' class='button-secondary idgm-delete-game-button' onclick=\"jQuery('#idgm-delete-game-form-id').val("+jQuery('#idgm-edit-game-form-id').val()+");\"><?php _e( "Delete", 'indiedev-game-marketer' ) ?></a></td><td>"+jQuery('#idgm-edit-game-form-name').val()+"</td></tr>");
                                jQuery('#idgm_edit_game_dialog').hide('fold');
                                jQuery('#idgm_add_game_button').show('fold');  
                                jQuery('#idgm_edit_game_list').show('fold'); 
                                jQuery('html, body').animate({ scrollTop: 0 }, 'fast');
                                jQuery("body").css("cursor", "default");
                        });
                });
                </script> <?php
        }        
        
        public function idgm_allowed_html() {
            $return_value = array(
                            'address' => array(),
                            'a' => array(
                                    'href' => true,
                                    'rel' => true,
                                    'rev' => true,
                                    'name' => true,
                                    'target' => true,
                            ),
                            'abbr' => array(),
                            'acronym' => array(),
                            'area' => array(
                                    'alt' => true,
                                    'coords' => true,
                                    'href' => true,
                                    'nohref' => true,
                                    'shape' => true,
                                    'target' => true,
                            ),
                            'article' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'aside' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'audio' => array(
                                    'autoplay' => true,
                                    'controls' => true,
                                    'loop' => true,
                                    'muted' => true,
                                    'preload' => true,
                                    'src' => true,
                            ),
                            'b' => array(),
                            'bdo' => array(
                                    'dir' => true,
                            ),
                            'big' => array(),
                            'blockquote' => array(
                                    'cite' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'br' => array(),
                            'button' => array(
                                    'disabled' => true,
                                    'name' => true,
                                    'type' => true,
                                    'value' => true,
                            ),
                            'caption' => array(
                                    'align' => true,
                            ),
                            'cite' => array(
                                    'dir' => true,
                                    'lang' => true,
                            ),
                            'code' => array(),
                            'col' => array(
                                    'align' => true,
                                    'char' => true,
                                    'charoff' => true,
                                    'span' => true,
                                    'dir' => true,
                                    'valign' => true,
                                    'width' => true,
                            ),
                            'colgroup' => array(
                                    'align' => true,
                                    'char' => true,
                                    'charoff' => true,
                                    'span' => true,
                                    'valign' => true,
                                    'width' => true,
                            ),
                            'del' => array(
                                    'datetime' => true,
                            ),
                            'dd' => array(),
                            'dfn' => array(),
                            'details' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'open' => true,
                                    'xml:lang' => true,
                            ),
                            'div' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'dl' => array(),
                            'dt' => array(),
                            'em' => array(),
                            'fieldset' => array(),
                            'figure' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'figcaption' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'font' => array(
                                    'color' => true,
                                    'face' => true,
                                    'size' => true,
                            ),
                            'footer' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'form' => array(
                                    'action' => true,
                                    'accept' => true,
                                    'accept-charset' => true,
                                    'enctype' => true,
                                    'method' => true,
                                    'name' => true,
                                    'target' => true,
                            ),
                            'h1' => array(
                                    'align' => true,
                            ),
                            'h2' => array(
                                    'align' => true,
                            ),
                            'h3' => array(
                                    'align' => true,
                            ),
                            'h4' => array(
                                    'align' => true,
                            ),
                            'h5' => array(
                                    'align' => true,
                            ),
                            'h6' => array(
                                    'align' => true,
                            ),
                            'header' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'hgroup' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'hr' => array(
                                    'align' => true,
                                    'noshade' => true,
                                    'size' => true,
                                    'width' => true,
                            ),
                            'i' => array(),
                            'img' => array(
                                    'alt' => true,
                                    'align' => true,
                                    'border' => true,
                                    'height' => true,
                                    'hspace' => true,
                                    'longdesc' => true,
                                    'vspace' => true,
                                    'src' => true,
                                    'usemap' => true,
                                    'width' => true,
                            ),
                            'ins' => array(
                                    'datetime' => true,
                                    'cite' => true,
                            ),
                            'kbd' => array(),
                            'label' => array(
                                    'for' => true,
                            ),
                            'legend' => array(
                                    'align' => true,
                            ),
                            'li' => array(
                                    'align' => true,
                                    'value' => true,
                            ),
                            'map' => array(
                                    'name' => true,
                            ),
                            'mark' => array(),
                            'menu' => array(
                                    'type' => true,
                            ),
                            'nav' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'p' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'pre' => array(
                                    'width' => true,
                            ),
                            'q' => array(
                                    'cite' => true,
                            ),
                            's' => array(),
                            'samp' => array(),
                            'span' => array(
                                    'dir' => true,
                                    'align' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'section' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'small' => array(),
                            'strike' => array(),
                            'strong' => array(),
                            'sub' => array(),
                            'summary' => array(
                                    'align' => true,
                                    'dir' => true,
                                    'lang' => true,
                                    'xml:lang' => true,
                            ),
                            'sup' => array(),
                            'table' => array(
                                    'align' => true,
                                    'bgcolor' => true,
                                    'border' => true,
                                    'cellpadding' => true,
                                    'cellspacing' => true,
                                    'dir' => true,
                                    'rules' => true,
                                    'summary' => true,
                                    'width' => true,
                            ),
                            'tbody' => array(
                                    'align' => true,
                                    'char' => true,
                                    'charoff' => true,
                                    'valign' => true,
                            ),
                            'td' => array(
                                    'abbr' => true,
                                    'align' => true,
                                    'axis' => true,
                                    'bgcolor' => true,
                                    'char' => true,
                                    'charoff' => true,
                                    'colspan' => true,
                                    'dir' => true,
                                    'headers' => true,
                                    'height' => true,
                                    'nowrap' => true,
                                    'rowspan' => true,
                                    'scope' => true,
                                    'valign' => true,
                                    'width' => true,
                            ),
                            'textarea' => array(
                                    'cols' => true,
                                    'rows' => true,
                                    'disabled' => true,
                                    'name' => true,
                                    'readonly' => true,
                            ),
                            'tfoot' => array(
                                    'align' => true,
                                    'char' => true,
                                    'charoff' => true,
                                    'valign' => true,
                            ),
                            'th' => array(
                                    'abbr' => true,
                                    'align' => true,
                                    'axis' => true,
                                    'bgcolor' => true,
                                    'char' => true,
                                    'charoff' => true,
                                    'colspan' => true,
                                    'headers' => true,
                                    'height' => true,
                                    'nowrap' => true,
                                    'rowspan' => true,
                                    'scope' => true,
                                    'valign' => true,
                                    'width' => true,
                            ),
                            'thead' => array(
                                    'align' => true,
                                    'char' => true,
                                    'charoff' => true,
                                    'valign' => true,
                            ),
                            'title' => array(),
                            'tr' => array(
                                    'align' => true,
                                    'bgcolor' => true,
                                    'char' => true,
                                    'charoff' => true,
                                    'valign' => true,
                            ),
                            'track' => array(
                                    'default' => true,
                                    'kind' => true,
                                    'label' => true,
                                    'src' => true,
                                    'srclang' => true,
                            ),
                            'tt' => array(),
                            'u' => array(),
                            'ul' => array(
                                    'type' => true,
                            ),
                            'ol' => array(
                                    'start' => true,
                                    'type' => true,
                                    'reversed' => true,
                            ),
                            'var' => array(),
                            'video' => array(
                                    'autoplay' => true,
                                    'controls' => true,
                                    'height' => true,
                                    'loop' => true,
                                    'muted' => true,
                                    'poster' => true,
                                    'preload' => true,
                                    'src' => true,
                                    'width' => true,
                            ),
                    ); 
            
            return $return_value;
        }
        
        public function idgm_ajax_edit_game_callback() {
            
            $idgmallowedposttags = $this->idgm_allowed_html();     
            
            check_ajax_referer( 'indiedev-game-marketer', 'security' );
            $db_input['id'] = sanitize_text_field($_POST['id']);
            $db_input['name'] = sanitize_text_field($_POST['name']);
            $db_input['logo'] = sanitize_text_field($_POST['logo']);
            $db_input['icon'] = sanitize_text_field($_POST['icon']);
            $db_input['small_desc'] = stripslashes(wp_kses($_POST['small_desc'], $idgmallowedposttags));
            $db_input['long_desc'] = stripslashes(wp_kses($_POST['long_desc'], $idgmallowedposttags));
            $db_input['genres'] = sanitize_text_field($_POST['genres']);
            $db_input['multiplayer'] = sanitize_text_field($_POST['multiplayer']);
            $db_input['home_url'] = sanitize_text_field($_POST['home_url']);
            $db_input['developers'] = sanitize_text_field($_POST['developers']);
            $db_input['publishers'] = sanitize_text_field($_POST['publishers']);
            $db_input['distributors'] = sanitize_text_field($_POST['distributors']);
            $db_input['producers'] = sanitize_text_field($_POST['producers']);
            $db_input['designers'] = sanitize_text_field($_POST['designers']);
            $db_input['programmers'] = sanitize_text_field($_POST['programmers']);
            $db_input['artists'] = sanitize_text_field($_POST['artists']);
            $db_input['writers'] = sanitize_text_field($_POST['writers']);
            $db_input['composers'] = sanitize_text_field($_POST['composers']);
            $db_input['game_engine'] = sanitize_text_field($_POST['game_engine']);
            $db_input['franchise_series'] = sanitize_text_field($_POST['franchise_series']);
            $db_input['platform_a'] = sanitize_text_field($_POST['platform_a']);
            $db_input['release_date_a'] = sanitize_text_field($_POST['release_date_a']);
            $db_input['platform_b'] = sanitize_text_field($_POST['platform_b']);
            $db_input['release_date_b'] = sanitize_text_field($_POST['release_date_b']);
            $db_input['platform_c'] = sanitize_text_field($_POST['platform_c']);
            $db_input['release_date_c'] = sanitize_text_field($_POST['release_date_c']);
            $db_input['platform_d'] = sanitize_text_field($_POST['platform_d']);
            $db_input['release_date_d'] = sanitize_text_field($_POST['release_date_d']);
            $db_input['platform_e'] = sanitize_text_field($_POST['platform_e']);
            $db_input['release_date_e'] = sanitize_text_field($_POST['release_date_e']);
            $db_input['platform_f'] = sanitize_text_field($_POST['platform_f']);
            $db_input['release_date_f'] = sanitize_text_field($_POST['release_date_f']);
            $db_input['platform_g'] = sanitize_text_field($_POST['platform_g']);
            $db_input['release_date_g'] = sanitize_text_field($_POST['release_date_g']);
            $db_input['platform_h'] = sanitize_text_field($_POST['platform_h']);
            $db_input['release_date_h'] = sanitize_text_field($_POST['release_date_h']);
            $db_input['platform_i'] = sanitize_text_field($_POST['platform_i']);
            $db_input['release_date_i'] = sanitize_text_field($_POST['release_date_i']);            
            $db_input['platform_j'] = sanitize_text_field($_POST['platform_j']);
            $db_input['release_date_j'] = sanitize_text_field($_POST['release_date_j']);
            $db_input['greenlight_url'] = sanitize_text_field($_POST['greenlight_url']);
            $db_input['release_a_url'] = sanitize_text_field($_POST['release_a_url']);
            $db_input['release_b_url'] = sanitize_text_field($_POST['release_b_url']);
            $db_input['release_c_url'] = sanitize_text_field($_POST['release_c_url']);
            $db_input['release_d_url'] = sanitize_text_field($_POST['release_d_url']);
            $db_input['release_e_url'] = sanitize_text_field($_POST['release_e_url']);
            $db_input['release_f_url'] = sanitize_text_field($_POST['release_f_url']);
            $db_input['release_g_url'] = sanitize_text_field($_POST['release_g_url']);
            $db_input['release_h_url'] = sanitize_text_field($_POST['release_h_url']);
            $db_input['release_i_url'] = sanitize_text_field($_POST['release_i_url']);
            $db_input['release_j_url'] = sanitize_text_field($_POST['release_j_url']);
            $this->idgm_edit_game($db_input);
        }
                    
        public function idgm_show_game_column($columns) {

            $new_columns = array(
                  'video_game' => __( 'Video Game', 'indiedev-game-marketer' ),
                  'game_promo' => __( 'Promo Type', 'indiedev-game-marketer' )
            );       
            
            $combined_columns = array_merge( $columns, $new_columns );
            
            return $combined_columns;
        }

        public function idgm_show_game_column_content($column) {
            if ($column == 'video_game') {
                global $post, $wpdb;
                $game_key = intval(get_post_meta($post->ID, 'idgm_promo_game_choice', true));
                $results = $wpdb->get_results("SELECT `name` FROM `{$wpdb->prefix}idgm_games` WHERE `id`={$game_key};", ARRAY_A);
                if (isset($results[0]['name'])) {
                    echo $results[0]['name'];
                } else {
                    echo '<i>';_e('No game selected.', 'indiedev-game-marketer');echo'</i>';
                }
                
            } elseif ($column == 'game_promo') {
                global $post;
                $terms = get_the_terms( $post->ID, 'game_promo' );

                if ( $terms && ! is_wp_error( $terms ) ) {
                    $count = 0;
                    echo '<i>';
                    foreach ( $terms as $term ) {
                        if($count>0) {
                            echo ', ';
                        }
                        echo $term->name;
                        $count++;
                    }
                    echo '</i>';
                }
            
            }
        }
        
        public function idgm_show_game_press_release_column($columns) {

            $new_columns = array(
                  'video_game' => __( 'Video Game', 'indiedev-game-marketer' )
            );       
            
            $combined_columns = array_merge( $columns, $new_columns );
            
            return $combined_columns;
        }

        public function idgm_show_game_press_release_column_content($column) {
            if ($column == 'video_game') {
                global $post, $wpdb;
                $game_key = intval(get_post_meta($post->ID, 'idgm_promo_game_choice', true));
                $results = $wpdb->get_results("SELECT `name` FROM `{$wpdb->prefix}idgm_games` WHERE `id`={$game_key};", ARRAY_A);
                if (isset($results[0]['name'])) {
                    echo $results[0]['name'];
                } else {
                    echo '<i>';_e('No game selected.', 'indiedev-game-marketer');echo'</i>';
                }
                
            } 
        }        
        
        public function add_new_page($page_title, $page_content='', $parent_id = 0, $post_type='page', $post_status='draft') {
            global $current_user;
            wp_get_current_user();
            if ( 0 == $current_user->ID ) {
                // Not logged in.
                return 0;                
            } else {
                if ( function_exists('current_user_can') && !current_user_can('edit_posts') ) {
                    return 0;                 
                } else {
                    $my_post = array();
                    $my_post['post_title'] = stripslashes($page_title);
                    $my_post['post_type'] = $post_type;
                    $my_post['post_content'] = $page_content;
                    $my_post['post_status'] = $post_status;
                    $my_post['post_author'] = $current_user->ID;
                    if($parent_id!=0) {
                        $my_post['post_parent'] = $parent_id;
                    }
                    // Insert the PAGE into the WP database
                    $thePostID = wp_insert_post( $my_post );	
                    if($thePostID==0) {
                        return 0;
                    } else {
                        return $thePostID;            
                    }
                }
            }
        }
        
	/**
	 * Plugin Settings Link on plugin page
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function add_settings_link( $links ) {

		$mylinks = array(
			'<a href="' . admin_url( 'options-general.php?page=indiedev-game-marketer' ) . '"><strong>'.__('Settings','indiedev-game-marketer').'</strong></a>',
		);
		return array_merge( $links, $mylinks );
	}        
        
	/**
	 * Register the stylesheets for the admin area.
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
                global $pagenow;
                if ($pagenow == 'admin.php') {
                    if (@$_GET['page']=='indiedev-game-marketer') {
                        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/indiedev-game-marketer-admin.css', array(), $this->version, 'all' );
                        wp_enqueue_style('jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.css', array(), $this->version, 'all' );
                    }
                }                 
	}

	/**
	 * Register the JavaScript for the admin area.
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
                global $pagenow;
                if ($pagenow == 'admin.php') {
                    if (@$_GET['page']=='indiedev-game-marketer') {
                        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/indiedev-game-marketer-admin.js', array( 'jquery' ), $this->version, false );
                        wp_enqueue_script('jquery-effects-core');
                        wp_enqueue_script('jquery-ui-datepicker');
                        
                        wp_enqueue_script('jquery-effects-fold');
                        wp_enqueue_media();
                    }
                }       
                wp_enqueue_script('jquery-ui-dialog');
	}

	/**
	 * Callback function for the admin settings page.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page(){	
                
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/indiedev-game-marketer-admin-display.php';
	}        
        
}
