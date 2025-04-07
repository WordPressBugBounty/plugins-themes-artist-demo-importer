<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://themesartist.com
 * @since      1.0.0
 *
 * @package    Themesartist_Demo_Importer
 * @subpackage Themesartist_Demo_Importer/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Themesartist_Demo_Importer
 * @subpackage Themesartist_Demo_Importer/includes
 * @author     Themes Artist <mail.themesartist@gmail.com>
 */
class Themesartist_Demo_Importer_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'themesartist-demo-importer',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
