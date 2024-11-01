<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://webavenue.com.au/wpnewslettercampaign
 * @since             1.0.0
 * @package           Wpnewsletter_Campaign
 *
 * @wordpress-plugin
 * Plugin Name:       Wp2Newsletter
 * Plugin URI:        http://webavenue.com.au/wpnewslettercampaign
 * Description:       Wp2Newsletter is an exclusive wordpress plugin to generate newsletter campaigns from contents of any post types supported by wordpress.
 * Version:           1.0.0
 * Author:            WebAvenue
 * Author URI:        http://webavenue.com.au/wpnewslettercampaign
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpnewsletter-campaign
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wpnewsletter-campaign-activator.php
 */
function activate_wpnewsletter_campaign() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpnewsletter-campaign-activator.php';
	Wpnewsletter_Campaign_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wpnewsletter-campaign-deactivator.php
 */
function deactivate_wpnewsletter_campaign() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wpnewsletter-campaign-deactivator.php';
	Wpnewsletter_Campaign_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wpnewsletter_campaign' );
register_deactivation_hook( __FILE__, 'deactivate_wpnewsletter_campaign' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wpnewsletter-campaign.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wpnewsletter_campaign() {

	$plugin = new Wpnewsletter_Campaign();
	$plugin->run();

}
run_wpnewsletter_campaign();
