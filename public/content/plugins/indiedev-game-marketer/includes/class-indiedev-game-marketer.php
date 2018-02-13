<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://blacklodgegames.com
 * @since      1.0.0
 *
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Indiedev_Game_Marketer
 * @subpackage Indiedev_Game_Marketer/includes
 * @author     BLACK LODGE GAMES, LLC <jeff@blacklodgegames.com>
 */
class Indiedev_Game_Marketer {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Indiedev_Game_Marketer_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

     
        
	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
                global $Indiedev_Game_Marketer_dbVersion;
		$this->plugin_name = 'indiedev-game-marketer';
		$this->version = '1.0.3';
                
                $Indiedev_Game_Marketer_dbVersion = '1.0.3';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Indiedev_Game_Marketer_Loader. Orchestrates the hooks of the plugin.
	 * - Indiedev_Game_Marketer_i18n. Defines internationalization functionality.
	 * - Indiedev_Game_Marketer_Admin. Defines all hooks for the admin area.
	 * - Indiedev_Game_Marketer_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-indiedev-game-marketer-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-indiedev-game-marketer-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-indiedev-game-marketer-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-indiedev-game-marketer-public.php';

		$this->loader = new Indiedev_Game_Marketer_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Indiedev_Game_Marketer_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Indiedev_Game_Marketer_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Indiedev_Game_Marketer_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
                $this->loader->add_action( "admin_menu", $plugin_admin, 'idgm_admin_menu', 9 );
                $this->loader->add_action( 'admin_init', $plugin_admin, 'Indiedev_Game_Marketer_settings_init' );
                $this->loader->add_filter( 'mce_external_plugins', $plugin_admin, 'add_button' );
                $this->loader->add_filter( 'mce_buttons', $plugin_admin, 'register_button' );               
                $this->loader->add_filter( 'plugin_action_links_indiedev-game-marketer/indiedev-game-marketer.php', $plugin_admin, 'add_settings_link' );
                $this->loader->add_action( 'save_post', $plugin_admin, 'idgm_save_promo_game_id' );                
                $this->loader->add_action( 'admin_footer', $plugin_admin, 'idgm_ajax_save_game' );
                $this->loader->add_action( 'admin_footer', $plugin_admin, 'idgm_ajax_delete_game' );
                $this->loader->add_action( 'admin_footer', $plugin_admin, 'idgm_ajax_test_twitter' );
                $this->loader->add_action( 'admin_footer', $plugin_admin, 'idgm_ajax_schedule_tweet' );
                $this->loader->add_action( 'admin_footer', $plugin_admin, 'idgm_ajax_edit_game' );
                $this->loader->add_action( 'admin_footer', $plugin_admin, 'idgm_ajax_create_presskit' );
                $this->loader->add_action( 'admin_footer', $plugin_admin, 'idgm_ajax_show_scheduled_tweets' );
                $this->loader->add_action( 'wp_ajax_idgm_save_new_game', $plugin_admin, 'idgm_ajax_save_game_callback' );
                $this->loader->add_action( 'wp_ajax_idgm_edit_game', $plugin_admin, 'idgm_ajax_edit_game_callback' );
                $this->loader->add_action( 'wp_ajax_idgm_press_release_button_game', $plugin_admin, 'idgm_ajax_press_release_button_game_callback' );
                $this->loader->add_action( 'wp_ajax_idgm_delete_game', $plugin_admin, 'idgm_ajax_delete_game_callback' );
                $this->loader->add_action( 'wp_ajax_idgm_test_twitter', $plugin_admin, 'idgm_ajax_test_twitter_callback' );
                $this->loader->add_action( 'wp_ajax_idgm_ajax_tinymce', $plugin_admin, 'idgm_ajax_tinymce_callback' );
                $this->loader->add_action( 'wp_ajax_idgm_schedule_tweet', $plugin_admin, 'idgm_ajax_schedule_tweet_callback' );
                $this->loader->add_action( 'wp_ajax_idgm_create_presskit', $plugin_admin, 'idgm_ajax_create_presskit_callback' );
                $this->loader->add_action( 'wp_ajax_idgm_show_scheduled_tweets', $plugin_admin, 'idgm_ajax_show_scheduled_tweets_callback' );
                $this->loader->add_filter( 'manage_promo_materials_posts_columns', $plugin_admin, 'idgm_show_game_column' );
                $this->loader->add_action( 'manage_promo_materials_posts_custom_column', $plugin_admin, 'idgm_show_game_column_content' );
                $this->loader->add_filter( 'manage_press_releases_posts_columns', $plugin_admin, 'idgm_show_game_press_release_column' );
                $this->loader->add_action( 'manage_press_releases_posts_custom_column', $plugin_admin, 'idgm_show_game_press_release_column_content' );
                
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Indiedev_Game_Marketer_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
                $this->loader->add_action( 'init', $plugin_public, 'Indiedev_Game_Marketer_promo_posttype' );
                global $idgm_flush_rules;
                if ($idgm_flush_rules == true) {
                    flush_rewrite_rules();
                    $idgm_flush_rules = false;
                }
                $this->loader->add_action( 'parse_request', $plugin_public, 'greenlight_parse_request' );
                $this->loader->add_filter( 'query_vars', $plugin_public, 'greenlight_query_vars' );
                $this->loader->add_action( 'wpmu_new_blog', $plugin_public, 'create_new_network_blog' );
                
                $this->loader->add_action( 'plugins_loaded', $plugin_public, 'implement_upgrade' );
                
                add_shortcode('indiedev', array($plugin_public, 'indiedev_game_marketer_shortcode'));
                
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Indiedev_Game_Marketer_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
