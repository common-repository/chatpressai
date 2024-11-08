<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://www.blackandwhitedigital.eu/
 * @since      1.0.0
 *
 * @package    Chatpressai
 * @subpackage Chatpressai/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Chatpressai
 * @subpackage Chatpressai/public
 * @author     Black and White Digital OU <paul@blackandwhitedigital.eu>
 */
class Chatpressai_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The helper functions of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Chatpressai_Helper    $helper    The current helper functions of this plugin.
	 */
	private $helper;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param string $plugin_name       The name of this plugin.
	 * @param string $version    The version of this plugin.
	 * @param string $helper    The helper functions of this plugin.
	 */
	public function __construct( $plugin_name, $version, $helper ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->helper      = $helper;

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
		 * defined in Chatpressai_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chatpressai_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'css/chatpressai-public.css',
			array(),
			$this->version,
			'all'
		);

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
		 * defined in Chatpressai_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Chatpressai_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script(
			$this->plugin_name,
			plugin_dir_url( __FILE__ ) . 'js/chatpressai-public.js',
			array( 'jquery' ),
			$this->version,
			false
		);
		wp_localize_script(
			$this->plugin_name,
			'chatpressai_ajax_var',
			array(
				'admin_ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'          => wp_create_nonce( 'nonce_chatpressai_ajax' ),
				'have_premium'   => class_exists( 'Chatpressai_Premium' ) ? 'yes' : 'no',
			),
		);
	}


}
