<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themesartist.com
 * @since             1.0.0
 * @package           Themesartist_Demo_Importer
 *
 * @wordpress-plugin
 * Plugin Name:       Themes Artist Demo Importer
 * Plugin URI:        https://themesartist.com
 * Description:       This plugin is used to import demo content of all free version Themes Artist themes.
 * Version:           1.0.8
 * Author:            Themes Artist
 * Author URI:        https://themesartist.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       themesartist-demo-importer
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
define( 'THEMESARTIST_DEMO_IMPORTER_VERSION', '1.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-themesartist-demo-importer-activator.php
 */
function themesartist_demo_importer_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-themesartist-demo-importer-activator.php';
	Themesartist_Demo_Importer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-themesartist-demo-importer-deactivator.php
 */
function themesartist_demo_importer_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-themesartist-demo-importer-deactivator.php';
	Themesartist_Demo_Importer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'themesartist_demo_importer_activate' );
register_deactivation_hook( __FILE__, 'themesartist_demo_importer_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-themesartist-demo-importer.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function themesartist_demo_importer_run() {

	$plugin = new Themesartist_Demo_Importer();
	$plugin->run();

}
themesartist_demo_importer_run();
