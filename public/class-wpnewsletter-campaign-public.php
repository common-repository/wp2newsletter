<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://webavenue.com.au/wpnewslettercampaign
 * @since      1.0.0
 *
 * @package    Wpnewsletter_Campaign
 * @subpackage Wpnewsletter_Campaign/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wpnewsletter_Campaign
 * @subpackage Wpnewsletter_Campaign/public
 * @author     WebAvenue<info@webavenue.com.au>
 */
class Wpnewsletter_Campaign_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wpnewsletter_campaign    The ID of this plugin.
	 */
	private $wpnewsletter_campaign;

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
	 * @param      string    $wpnewsletter_campaign       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wpnewsletter_campaign, $version ) {

		$this->wpnewsletter_campaign = $wpnewsletter_campaign;
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
		 * defined in Wpnewsletter_Campaign_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpnewsletter_Campaign_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wpnewsletter_campaign, plugin_dir_url( __FILE__ ) . 'css/wpnewsletter-campaign-public.css', array(), $this->version, 'all' );

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
		 * defined in Wpnewsletter_Campaign_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wpnewsletter_Campaign_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wpnewsletter_campaign, plugin_dir_url( __FILE__ ) . 'js/wpnewsletter-campaign-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	*Function to define our template file path for newsletter campaign posts single page
	*
	*/
	public function wpnewsletter_template($single){
		global $wp_query, $post;
		if($post->post_type !='wpnlc'){
			return $single;
			}
		return plugin_dir_path( dirname( __FILE__ ) ) . 'public/templates/wpnlc_feeds.php';die;
	}
	
	public function wpnlc_rss_limit_words($text,$limit){
		  if (str_word_count($text, 0) > $limit) {
			  $words = str_word_count($text, 2);
			  $pos = array_keys($words);
			  $text = substr($text, 0, $pos[$limit]) . '...';
		  }
		  return $text;
		}	
}
