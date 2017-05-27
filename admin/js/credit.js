( function( $ ) {
	$(document).ready(function(){


		$(".btn-approve").click(function(){
			var _this = $(event.currentTarget);
			var action = 'approve-order';
			var data = {order_id:''};
			data.order_id = _this.attr('id');
			window.ajaxSend.Custom(data, action);

		});

	});
})(jQuery, window.ajaxSend);
