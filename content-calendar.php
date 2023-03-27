<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://atul.com
 * @since             1.0.0
 * @package           Content_Calendar
 *
 * @wordpress-plugin
 * Plugin Name:       content calendar
 * Plugin URI:        https://atul.com/atul-plugin
 * Description:       plugin for content calendar
 * Version:           1.0.0
 * Author:            atul.com/atul-plugin
 * Author URI:        https://atul.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       content-calendar
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CONTENT_CALENDAR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-content-calendar-activator.php
 */
function activate_content_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-calendar-activator.php';
	Content_Calendar_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-content-calendar-deactivator.php
 */
function deactivate_content_calendar() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-content-calendar-deactivator.php';
	Content_Calendar_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_content_calendar' );
register_deactivation_hook( __FILE__, 'deactivate_content_calendar' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-content-calendar.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_content_calendar() {

	$plugin = new Content_Calendar();
	$plugin->run();

}
run_content_calendar();
