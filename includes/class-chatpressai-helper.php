<?php
/**
 * Fired during plugin activation
 *
 * @link       https://https://www.blackandwhitedigital.eu/
 * @since      1.0.0
 *
 * @package    Chatpressai
 * @subpackage Chatpressai/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Chatpressai
 * @subpackage Chatpressai/includes
 * @author     Black and White Digital OU <paul@blackandwhitedigital.eu>
 */
class Chatpressai_Helper {

	/**
	 * It creates a nonce field, a div for the response, a button to clear the chat, a text input field,
	 * and a button to send the input
	 */
	public function chat_box() {
		?>
		<div class="chatpressai-chat-container">
			<?php wp_nonce_field( 'chatpressai_prompt', '_nonce_chatpressai_prompt' ); ?>
			<div id="Chatpressai-Response"></div>
			<div style=" text-align: right; margin-top: 10px; "><button class="small chatpressai_clear_chat" type="button">Clear Chat</button></div>
			<label class="chatpressai_prompt" for="chatpressai_prompt">
				<input type="text" id="chatpressai_prompt" name="chatpressai_prompt" value="" size="25" />
				<button type="button" class="chatpressai_send_prompt">
					<?php echo esc_html__( 'Send', 'chatpressai' ); ?>
				</button>
			</label>
		</div>
		<?php
	}

}
