<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://webavenue.com.au/wpnewslettercampaign
 * @since      1.0.0
 *
 * @package    Wpnewsletter_Campaign
 * @subpackage Wpnewsletter_Campaign/includes
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
 * @package    Wpnewsletter_Campaign
 * @subpackage Wpnewsletter_Campaign/includes
 * @author     WebAvenue<info@webavenue.com.au>
 */
class Wpnewsletter_Campaign {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wpnewsletter_Campaign_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $wpnewsletter_campaign    The string used to uniquely identify this plugin.
	 */
	protected $wpnewsletter_campaign;

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

		$this->wpnewsletter_campaign = 'wpnewsletter-campaign';
		$this->version = '1.0.0';

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
	 * - Wpnewsletter_Campaign_Loader. Orchestrates the hooks of the plugin.
	 * - Wpnewsletter_Campaign_i18n. Defines internationalization functionality.
	 * - Wpnewsletter_Campaign_Admin. Defines all hooks for the admin area.
	 * - Wpnewsletter_Campaign_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpnewsletter-campaign-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpnewsletter-campaign-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpnewsletter-campaign-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpnewsletter-campaign-public.php';
		/**
		 * The class responsible for mailchimp api
		 * 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/mailchimp-api/Mailchimp.php';

		$this->loader = new Wpnewsletter_Campaign_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wpnewsletter_Campaign_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wpnewsletter_Campaign_i18n();

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

		$plugin_admin = new Wpnewsletter_Campaign_Admin( $this->get_wpnewsletter_campaign(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'register_wpnewsletter_campaign_posttypes' );
		$this->loader->add_action( 'init', $plugin_admin, 'wpnewsletter_campaign_settings' );
		$this->loader->add_action( 'post_row_actions', $plugin_admin, 'wpnlc_remove_row_actions',10,1 );
		$this->loader->add_action( 'add_meta_boxes_wpnlc', $plugin_admin, 'wpnewsletter_campaign_metabox' );
		$this->loader->add_action( 'save_post_wpnlc',$plugin_admin,'wpnlc_save_metabox');
		$this->loader->add_action( 'add_meta_boxes_wpnlc_template', $plugin_admin, 'wpnewsletter_template_metabox' );
		$this->loader->add_action('save_post_wpnlc_template',$plugin_admin,'wpnlc_template_save_metabox');
		$this->loader->add_action('wp_ajax_wpnlc_get_datasource_categories',$plugin_admin,'wpnlc_get_datasource_categories');
		$this->loader->add_action('wp_ajax_wpncl_generate_campaigns',$plugin_admin,'wpncl_generate_campaigns');
		$this->loader->add_action('wp_ajax_wpnlc_save_settings',$plugin_admin,'wpnlc_save_settings');
		$this->loader->add_action('wp_ajax_wpnlc_get_mc_template_id',$plugin_admin,'wpnlc_get_mc_template_id');
		$this->loader->add_action('wp_ajax_search_post_ajax',$plugin_admin,'search_post_ajax');
		$this->loader->add_action('wp_ajax_get_templates_by_type',$plugin_admin,'get_templates_by_type');
		$this->loader->add_action('wp_ajax_wpnlc_get_feed_types',$plugin_admin,'wpnlc_get_feed_types');
		$this->loader->add_action( 'manage_wpnlc_posts_custom_column', $plugin_admin, 'wpnlc_datsource_coloumn_content',10,2 );
		$this->loader->add_filter('manage_wpnlc_posts_columns',$plugin_admin,'wpnlc_datasource_coloumn_head');
		$this->loader->add_action('wp_ajax_wpnlc_found_post_count',$plugin_admin,'wpnlc_found_post_count');

		$this->loader->add_action( 'manage_wpnlc_template_posts_custom_column', $plugin_admin, 'wpnlc_template_coloumn_content',10,2 );
		$this->loader->add_filter('manage_wpnlc_template_posts_columns',$plugin_admin,'wpnlc_template_coloumn_head');

		$this->loader->add_action( 'restrict_manage_posts', $plugin_admin, 'wpnlc_admin_posts_filter_restrict_manage_posts',10,2 );
		$this->loader->add_filter('parse_query',$plugin_admin,'wpnlc_custom_post_type_filter');
		
		
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wpnewsletter_Campaign_Public( $this->get_wpnewsletter_campaign(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'single_template', $plugin_public, 'wpnewsletter_template' );

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
	public function get_wpnewsletter_campaign() {
		return $this->wpnewsletter_campaign;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wpnewsletter_Campaign_Loader    Orchestrates the hooks of the plugin.
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
	
	/*
	*Function to trim string to given word count with trailing ...
	*
	*/	

}
