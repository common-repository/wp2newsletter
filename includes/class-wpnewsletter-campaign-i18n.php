<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://webavenue.com.au/wpnewslettercampaign
 * @since      1.0.0
 *
 * @package    Wpnewsletter_Campaign
 * @subpackage Wpnewsletter_Campaign/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wpnewsletter_Campaign
 * @subpackage Wpnewsletter_Campaign/includes
 * @author     WebAvenue<info@webavenue.com.au>
 */
class Wpnewsletter_Campaign_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wpnewsletter-campaign',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
