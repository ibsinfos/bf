( function( $ ) {
	var msg = {
		init: function(){
			$( '.render-conv' ).on('click', this.rederConversation);
			console.log('init MSG');

		},
		rederConversation: function(event){

			var element = $(event.currentTarget);
			var id = element.attr('id');
			var success = function(res){
				$("#box_chat").html('');
				$.each( res.data, function( key, value ) {
					$("#box_chat").append(value.msg_content + '<br />');
				});
			};

			var data = {action: 'sync_msg', method: 'get_converstaion', group:id};
			window.ajaxSend.Custom(data,success);
			return false;
		},
		paging: function(event){

		}
	}
	msg.init();
})( jQuery, window.ajaxSend );