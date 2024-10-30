<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://www.blackandwhitedigital.eu/
 * @since      1.0.0
 *
 * @package    Chatpressai
 * @subpackage Chatpressai/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Chatpressai
 * @subpackage Chatpressai/admin
 * @author     Black and White Digital OU <paul@blackandwhitedigital.eu>
 */
class Chatpressai_Admin {

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
	 * Register the stylesheets for the admin area.
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
			plugin_dir_url( __FILE__ ) . 'css/chatpressai-admin.css',
			array(),
			$this->version,
			'all'
		);

	}

	/**
	 * Register the JavaScript for the admin area.
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
			plugin_dir_url( __FILE__ ) . 'js/chatpressai-admin.js',
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

	/**
	 * It adds a menu item to the admin menu.
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {
		add_menu_page(
			esc_html__( 'ChatPressAI', 'chatpressai' ),
			esc_html__( 'ChatPressAI', 'chatpressai' ),
			'manage_options',
			'chatpressai',
			array( $this, 'chatpressai_form' ),
			'',
			6
		);

		add_submenu_page(
			'chatpressai',
			esc_html__( 'API Settings', 'chatpressai' ),
			esc_html__( 'API Settings', 'chatpressai' ),
			'manage_options',
			'chatpressai',
			array( $this, 'chatpressai_form' ),
		);

		add_submenu_page(
			'chatpressai',
			esc_html__( 'Chat/Query', 'chatpressai' ),
			esc_html__( 'Chat/Query', 'chatpressai' ),
			'manage_options',
			'chat',
			array( $this, 'chat_calllback' ),
		);
	}

	/**
	 * Display callback for the submenu page.
	 */
	public function chat_calllback() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html__( 'Chat/Query', 'chatpressai' ); ?></h1>
			<?php $this->helper->chat_box(); ?>
		</div>
		<?php
	}
	/**
	 * If the nonce is valid, update the option with the new value
	 *
	 * @since    1.0.0
	 */
	public function chatpressai_form() {
		$message = array();
		if ( isset( $_POST['_nonce_chatpressai_options'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_nonce_chatpressai_options'] ) ), 'chatpressai' ) ) {
			$chatpressai_api_key = isset( $_POST['chatpressai_api_key'] ) ? sanitize_text_field( wp_unslash( $_POST['chatpressai_api_key'] ) ) : '';
			$chatpressai_model   = isset( $_POST['chatpressai_model'] ) ? sanitize_text_field( wp_unslash( $_POST['chatpressai_model'] ) ) : 'text-davinci-003';
			update_option( 'chatpressai_api_key', $chatpressai_api_key );
			update_option( 'chatpressai_model', $chatpressai_model );
			$message[] = 'Updated sucessfully';
		}
		$chatpressai_api_key = get_option( 'chatpressai_api_key' );
		$chatpressai_model   = get_option( 'chatpressai_model' );

		$tab = isset( $_GET['tab'] ) && ! empty( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'guide';
		?>
		<div class="wrap">
			<h2><?php echo esc_html__( 'ChatPressAI Settings', 'chatpressai' ); ?></h2> 
			<hr class="wp-header-end">
			<ul class="subsubsub">
				<li class="
				<?php
				if ( 'guide' === $tab ) {
					?>
					active
					<?php
				}
				?>
				"><a href="admin.php?page=chatpressai&tab=guide" class="
				<?php
				if ( 'guide' === $tab ) {
					?>
					current
					<?php
				}
				?>
				" aria-current="page">Guide</a> |</li>
				<li class="
				<?php
				if ( 'api-key' === $tab ) {
					?>
					active
					<?php
				}
				?>
				"><a href="admin.php?page=chatpressai&tab=api-key" class="
					<?php
					if ( 'api-key' === $tab ) {
						?>
						current
						<?php
					}
					?>
					">API Key</a> </li>
			</ul>
			<div class="wp-clearfix"></div>

			<?php if ( 'api-key' === $tab ) { ?>
			<form method="post">
				<?php
				if ( ! empty( $message ) ) {
					foreach ( $message as $value ) {
						echo '<p>' . esc_html( $value ) . '</p>';
					}
				}
				?>
				<?php wp_nonce_field( 'chatpressai', '_nonce_chatpressai_options' ); ?>
				<p>
					<label for="chatpressai_api_key">API Key:</label>
					<input type="text" name="chatpressai_api_key" id="chatpressai_api_key" value="<?php echo esc_attr( $chatpressai_api_key ); ?>">
				</p>
				<p>
					<label for="chatpressai_model">Model:</label>
					<select name="chatpressai_model" id="chatpressai_model">
						<option value="text-davinci-003" <?php selected( $chatpressai_model, 'text-davinci-003' ); ?>>
							<?php echo esc_html__( 'text-davinci-003', 'chatpressai' ); ?>
						</option>
						<option value="text-curie-001" <?php selected( $chatpressai_model, 'text-curie-001' ); ?>>
							<?php echo esc_html__( 'text-curie-001', 'chatpressai' ); ?>
						</option>
						<option value="text-babbage-001" <?php selected( $chatpressai_model, 'text-babbage-001' ); ?>>
							<?php echo esc_html__( 'text-babbage-001', 'chatpressai' ); ?>
						</option>
						<option value="text-ada-001" <?php selected( $chatpressai_model, 'text-ada-001' ); ?>>
							<?php echo esc_html__( 'text-ada-001', 'chatpressai' ); ?>
						</option>
						<option value="text-davinci-002-render" <?php selected( $chatpressai_model, 'text-davinci-002-render' ); ?>>
							<?php echo esc_html__( 'text-davinci-002-render', 'chatpressai' ); ?>
						</option>
					</select> 
				</p>
				<p>
					<input type="submit" value="Submit">
				</p>
			</form>

			<p>You can select from multiple models or versions of the OpenAI API. These are named alphabetically with the less powerfule models using earlier letters in their names, More powerful models will cost more and you should refer to this page for more information at <a target="_blank" href="https://openai.com/api/pricing/">https://openai.com/api/pricing/</a></p>
			As a quick guide:
			<h4>Davinci</h4>
			<p>Davinci is the most capable model and can perform any task the other models can perform, often with less instruction. For applications requiring deep understanding of the content, like summarization for a specific audience and creative content generation, Davinci produces the best results. The increased capabilities provided by Davinci require more compute resources, so Davinci costs more and isn't as fast as other models.</p>
			<p>Another area where Davinci excels is in understanding the intent of text. Davinci is excellent at solving many kinds of logic problems and explaining the motives of characters. Davinci has been able to solve some of the most challenging AI problems involving cause and effect.</p>
			<p><b>Use for:</b> Complex intent, cause and effect, summarization for audience</p>
			<h4>Curie</h4>
			<p>Curie is powerful, yet fast. While Davinci is stronger when it comes to analyzing complicated text, Curie is capable for many nuanced tasks like sentiment classification and summarization. Curie is also good at answering questions and performing Q&A and as a general service chatbot.</p>
			<p><b>Use for:</b> Language translation, complex classification, text sentiment, summarization</p>
			<h4>Babbage</h4>
			<p>Babbage can perform straightforward tasks like simple classification. It’s also capable when it comes to semantic search, ranking how well documents match up with search queries.</p>
			<p><b>Use for:</b> Moderate classification, semantic search classification</p>
			<h4>Ada</h4>
			<p>Ada is usually the fastest model and can perform tasks like parsing text, address correction and certain kinds of classification tasks that don’t require too much nuance. Ada’s performance can often be improved by providing more context.</p>
			<p><b>Use for:</b> Parsing text, simple classification, address correction, keywords</p>
			<?php } ?>
			<?php if ( 'guide' === $tab ) { ?>
				<h4>Account creation </h4>
				<p>
				To use OpenAI through API, you must create a free account and generate keys. Fortunately, it is pretty straightforward.</p>
				<ul>
					<li>1. Sign up here <a target="_blank" href="https://beta.openai.com/signup">https://beta.openai.com/signup</a>. You can use your Google or Microsoft account to sign up if you don't want to create using an email/password combination. You may need a valid mobile number to verify your account.</li>
					<li>2. Now, visit your OpenAI key page <a target="_blank" href="https://beta.openai.com/account/api-keys">https://beta.openai.com/account/api-keys</a></li>
					<li>3. Create a new key by clicking the "Create new secret key" button.</li>
					<li>4. Copy the AI Secret Key and Paste in the API Key field (located in the API tab above).</li>
				</ul>
			<?php } ?>

		</div>
		<?php
	}

	/**
	 * The function adds a meta box to the post and page edit screens.
	 *
	 * @param object $post_type The post type to which the meta box is added.
	 *
	 * @since    1.0.0
	 */
	public function add_meta_boxes( $post_type ) {
		// Limit meta box to certain post types.
		$post_types = array( 'post', 'page' );

		if ( in_array( $post_type, $post_types, true ) ) {
			add_meta_box(
				'some_meta_box_name',
				__( 'ChatPressAI', 'chatpressai' ),
				array( $this, 'render_meta_box_content' ),
				$post_type,
				'advanced',
				'high'
			);
		}
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 *
	 * @since    1.0.0
	 */
	public function render_meta_box_content( $post ) {
		$this->helper->chat_box();
	}

	/**
	 * We're using the OpenAI API to get a response to the user's input.
	 *
	 * @since    1.0.0
	 */
	public function chatpressai_get_response() {
		if ( isset( $_POST['_nonce_chatpressai_prompt'] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST['_nonce_chatpressai_prompt'] ) ), 'chatpressai_prompt' ) ) {

			$prompt              = isset( $_POST['chatpressai_prompt'] ) ? sanitize_text_field( wp_unslash( $_POST['chatpressai_prompt'] ) ) : '';
			$model               = get_option( 'chatpressai_model' ) ? get_option( 'chatpressai_model' ) : 'text-davinci-003';
			$chatpressai_api_key = get_option( 'chatpressai_api_key' ) ? get_option( 'chatpressai_api_key' ) : '';
			$max_tokens          = 300;

			if ( class_exists( 'Chatpressai_Premium' ) ) {
				$max_tokens = 4096;
			}

			$body = array(
				'prompt'            => $prompt,
				'max_tokens'        => $max_tokens,
				'model'             => $model,
				'temperature'       => 0,
				'top_p'             => 1,
				'frequency_penalty' => 0,
				'presence_penalty'  => 0,
			);

			$args = array(
				'body'    => json_encode( $body ),
				'timeout' => 300,
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . $chatpressai_api_key,
				),
			);

			$response = wp_remote_post( 'https://api.openai.com/v1/completions', $args );

			if ( ! is_wp_error( $response ) ) {
				$response = $response['body'];
				$text     = json_decode( $response )->choices[0]->text;
				$text     = preg_replace( '/^[ \t]*[\r\n]+/m', '', $text );
				echo esc_html( $text );
			}
		}
		die();
	}
}
