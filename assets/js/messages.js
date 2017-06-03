( function( $ ) {
	var username_display = 'Dan';
	var username_receiver = 'You';
	var msg_submit;
	var msg = {
		init: function(){
			msg_submit = {action: 'sync_msg', msg_content: '', method: 'insert', id:0 };
			$( '.render-conv' ).on('click', this.rederConversation);
			$( "form.send-message").live('submit', this.sendMessage);

			console.log('init MSG');

		},
		rederConversation: function(event){
			var element = $(event.currentTarget);
			var id = element.attr('id');
			msg_submit.id = id;
			var success = function(res){
				$("#box_chat").html('');
				var template = wp.template( 'msg_record' );
				$.each( res.data, function( key, value ) {

					$("#box_chat").append('<div class="row">'+username_display+': '+value.msg_content+'</div>');

				});
				$("#box_chat").append('<form class="send-message" ><textarea name="msg_content" class="full msg_content" rows="6" placeholder="Type your message here"></textarea><button type="submit" class="btn btn-send-message align-right f-right">Send</button></form>');
			};

			var data = {action: 'sync_msg', method: 'get_converstaion', id:id};
			window.ajaxSend.Custom(data,success);
			return false;
		},
		sendMessage: function(){
			var element = $(event.currentTarget);
			msg_submit.msg_content = element.find(".msg_content").val();


			var success = function(res){
		        console.log(res);
	        	if ( res.success ){
	        		$("#box_chat").append(msg_submit.msg_content);
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