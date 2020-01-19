<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://localhost/test.com
 * @since             1.0.0
 * @package           Vnins
 *
 * @wordpress-plugin
 * Plugin Name:       vn_institute
 * Plugin URI:        http://localhost/test.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            noname
 * Author URI:        http://localhost/test.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vnins
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
define( 'VNINS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vnins-activator.php
 */
function activate_vnins() {	
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vnins-activator.php';
	Vnins_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vnins-deactivator.php
 */
function deactivate_vnins() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vnins-deactivator.php';
	Vnins_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vnins' );
register_deactivation_hook( __FILE__, 'deactivate_vnins' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vnins.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vnins() {

	$plugin = new Vnins();
	$plugin->run();

}
add_action("init", "run_vnins");
