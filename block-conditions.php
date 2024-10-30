<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://chintesh.github.io/
 * @since             1.0.0
 * @package           Block_Conditions
 *
 * @wordpress-plugin
 * Plugin Name:       Block Conditions
 * Plugin URI:        -
 * Description:       This plugin can enable option for hide/show block in desktop/mobile/tablet. Show block by spacific user status like logged in, logged out. Hide block in spacific country as well
 * Version:           1.0.0
 * Author:            Chintesh Prajapati
 * Author URI:        https://chintesh.github.io/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       block-conditions
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
define( 'BLOCK_CONDITIONS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-block-conditions-activator.php
 */
function activate_block_conditions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-block-conditions-activator.php';
	Block_Conditions_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-block-conditions-deactivator.php
 */
function deactivate_block_conditions() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-block-conditions-deactivator.php';
	Block_Conditions_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_block_conditions' );
register_deactivation_hook( __FILE__, 'deactivate_block_conditions' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-block-conditions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_block_conditions() {

	$plugin = new Block_Conditions();
	$plugin->run();

}
run_block_conditions();
