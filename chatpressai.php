<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.blackandwhitedigital.eu/
 * @since             1.0.0
 * @package           Chatpressai
 *
 * @wordpress-plugin
 * Plugin Name:       ChatPressAI
 * Plugin URI:        https://www.blackandwhitedigital.eu/chatpressai
 * Description:       Use the ChatGPT API (separate free registration required) to write blog posts and other content right from within your WordPress site. Free version works in Page and Post edit screens to generate content where you need it most! Premium version extends post length and adds other useful features such as copy/paste direct into Post and Page edit screens and a front end interface so site users can also post queries.
 * Version:           1.0.1
 * Author:            Black and White Digital OU
 * Author URI:        https://www.blackandwhitedigital.eu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       chatpressai
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! function_exists( 'cha_fs' ) ) {
	// Create a helper function for easy SDK access.
	function cha_fs() {
		global $cha_fs;

		if ( ! isset( $cha_fs ) ) {
			// Activate multisite network integration.
			if ( ! defined( 'WP_FS__PRODUCT_11788_MULTISITE' ) ) {
				define( 'WP_FS__PRODUCT_11788_MULTISITE', true );
			}

			// Include Freemius SDK.
			require_once dirname(__FILE__) . '/freemius/start.php';

			$cha_fs = fs_dynamic_init( array(
				'id'                  => '11788',
				'slug'                => 'chatpressai',
				'type'                => 'plugin',
				'public_key'          => 'pk_980eaced2904b036890de28c3a9f0',
				'is_premium'          => false,
				'has_addons'          => true,
				'has_paid_plans'      => false,
				'menu'                => array(
					'slug'           => 'chatpressai',
					'first-path'     => 'admin.php?page=chatpressai',
					'support'        => false,
				),
			) );
		}

		return $cha_fs;
	}

	// Init Freemius.
	cha_fs();
	// Signal that SDK was initiated.
	do_action( 'cha_fs_loaded' );
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CHATPRESSAI_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-chatpressai-activator.php
 */
function activate_chatpressai() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chatpressai-activator.php';
	Chatpressai_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-chatpressai-deactivator.php
 */
function deactivate_chatpressai() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chatpressai-deactivator.php';
	Chatpressai_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_chatpressai' );
register_deactivation_hook( __FILE__, 'deactivate_chatpressai' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-chatpressai.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_chatpressai() {

	$plugin = new Chatpressai();
	$plugin->run();

}
run_chatpressai();
