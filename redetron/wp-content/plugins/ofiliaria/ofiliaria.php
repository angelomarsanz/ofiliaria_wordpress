<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://redetronic.com
 * @since             1.0.0
 * @package           Ofiliaria
 *
 * @wordpress-plugin
 * Plugin Name:       Ofiliaria
 * Plugin URI:        https://redetronic.com
 * Description:       Personalización de wpestate-crm de Wordpress
 * Version:           1.0.0
 * Author:            Ángel Omar Sanz
 * Author URI:        https://redetronic.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ofiliaria
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
define( 'OFILIARIA_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ofiliaria-activator.php
 */
function activate_ofiliaria() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ofiliaria-activator.php';
	Ofiliaria_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ofiliaria-deactivator.php
 */
function deactivate_ofiliaria() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ofiliaria-deactivator.php';
	Ofiliaria_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ofiliaria' );
register_deactivation_hook( __FILE__, 'deactivate_ofiliaria' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ofiliaria.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ofiliaria() {

	$plugin = new Ofiliaria();
	$plugin->run();

}
run_ofiliaria();
