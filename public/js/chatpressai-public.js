(function($) {
	'use strict';
	$.fn.enterKey = function(fnc) {
		return this.each(function() {
			$(this).keypress(function(ev) {
				var keycode = (ev.keyCode ? ev.keyCode : ev.which);
				if (keycode == '13') {
					fnc.call(this, ev);
				}
			})
		})
	}
	$(document).on('click', '.chatpressai_send_prompt', function(event) {
		var parent = $(this).parents('.chatpressai-chat-container');
		get_response(parent);
	})
	$(document).on('click', '.chat-response .chatpressai-toggle-actions', function(event) {
		$(this).parents('.chat-response').find('.chatpressai-actions-inner').toggle()
	})
	$(document).on('click', '.chatpressai_clear_chat', function(event) {
		$('#Chatpressai-Response').html('')
		return false;
	})
	$(document).on('keypress', '#chatpressai_prompt', function(e) {
		if (e.which == 13) {
			var parent = $(this).parents('.chatpressai-chat-container');
			get_response(parent);
			return false;
		}
	});
	$(document).on('click', '.chatpressai-actions-inner > div', function(event) {
		var attr_class = $(this).attr('class');
		var cont = $(this).parents('.chat-response').find('p').text();

		if (attr_class == 'copy-to-clipboard') {
			if (window.isSecureContext && navigator.clipboard) {
				navigator.clipboard.writeText(cont);
			} else {
				alert('Unsecured Connection: Unable to copy to clipboard. ');
			}
		}

		$('.chatpressai-actions-inner').hide()
	});

	function get_response(parent) {
		var action = ['Copy to Clipboard', ];
		if(chatpressai_ajax_var.have_premium==='no') {
			var action = [ ];
		}
		var action_html = '';
		action.forEach(ac => {
			action_html += '<div class="' + ac.replace(/\s+/g, '-').toLowerCase() + '">' + ac + '</div>';
		});
		var chatpressai_prompt = $(parent).find('#chatpressai_prompt').val();
		var _nonce_chatpressai_prompt = $(parent).find('#_nonce_chatpressai_prompt').val();
		$(parent).find('#chatpressai_prompt').val('');
		$(parent).find('#Chatpressai-Response').append('<div class="text-right">' + chatpressai_prompt + '</div>')
		var data = {
			'action': 'chatpressai_get_response',
			'chatpressai_prompt': chatpressai_prompt,
			'_nonce_chatpressai_prompt': _nonce_chatpressai_prompt,
		};
		$(parent).find('#Chatpressai-Response').append('<div class="chat-response"><div class="typing"> <span>.</span> <span>.</span> <span>.</span> </div></div>')
		$(parent).find('#Chatpressai-Response').animate({
			scrollTop: $(parent).find('#Chatpressai-Response').prop("scrollHeight")
		}, 500);
		$.post(chatpressai_ajax_var.admin_ajax_url, data).done(function(data) {
			$(parent).find('#Chatpressai-Response').children().last().html('<p>' + data + '</p>')
			if(chatpressai_ajax_var.have_premium==='yes') {
				$(parent).find('#Chatpressai-Response').children().last().append('<div class="chatpressai-actions"><div class="chatpressai-toggle-actions">Copy...</div><div class="chatpressai-actions-inner">' + action_html + '</div></div>')
			}
			$('#(parent).findChatpressai-Response').animate({
				scrollTop: $(parent).find('#Chatpressai-Response').prop("scrollHeight")
			}, 500);
		}).fail(function(data) {});
	}
})(jQuery);