( function( $ ) {
	var username_display = '';
	var username_receiver = 'You';
	var msg_submit;
	var msg = {
		init: function(){
			msg_submit = {action: 'sync_message', msg_content: '', method: 'insert', cvs_id:0 };
			msg_submit.cvs_id = $("#first_cvs").val();
			$( '.render-conv' ).on('click', this.rederConversation);
			$( "form.frm-send-message").live('submit', this.sendMessage);

			console.log('init MSG');
			var textarea = document.getElementById('container_msg');
				textarea.scrollTop = textarea.scrollHeight;

		},
		rederConversation: function(event){
			var element = $(event.currentTarget);
			var id = element.attr('id');
			msg_submit.cvs_id = id;
			var success = function(res){
				$("#container_msg").html('');
				var template = wp.template( 'msg_record' );
				$.each( res.data, function( key, value ) {
					username_display = 'You: ';
					if( value.sender_id != bx_global.user_ID){
						username_display = 'Partner: ';
					}
					$("#container_msg").append('<div class="msg-record msg-item"><div class="col-md-2">'+username_display + '</div><div class="col-md-10">' +value.msg_content+'</div></div>');

				});
				var textarea = document.getElementById('container_msg');
				textarea.scrollTop = textarea.scrollHeight;

				$("#form_reply").html('<form class="frm-send-message" ><textarea name="msg_content"  class="full msg_content" rows="3" placeholder="Type your message here"></textarea><button type="submit" class="btn btn-send-message align-right f-right">Send</button></form>');
			};

			var data = {action: 'sync_msg', method: 'get_converstaion', id:id};
			console.log(data);
			window.ajaxSend.Custom(data,success);
			return false;
		},
		sendMessage: function(){
			var element = $(event.currentTarget);
			msg_submit.msg_content = element.find(".msg_content").val();

			var success = function(res){
		        console.log(res);
	        	if ( res.success ){
	        		$("#container_msg").append('<div class="msg-record msg-item"><div class="col-md-2">&nbsp;</div><div class="col-md-10">' +msg_submit.msg_content+'</div></div>');
	        		$(".msg_content").html('');
	        		var textarea = document.getElementById('container_msg');
					textarea.scrollTop = textarea.scrollHeight;
	        		$("form.send-message").trigger("reset");
		        } else {
		        	alert(res.msg);
		        }
			}
			msg_submit.method = 'insert';
			window.ajaxSend.Custom(msg_submit, success);
			return false;
		},

		paging: function(event){

		}
	}
	msg.init();
})( jQuery, window.ajaxSend );