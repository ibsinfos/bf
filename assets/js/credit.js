( function( $ ) {
	var db_credit = {
		init: function() {
			$('form#frm_withdraw' ).on( 'submit', this.sendWithDraw);
			$('.btn-delete-job' ).on( 'click', this.actDelJob);
		},
		sendWithDraw : function(event){
			var _this = $(event.currentTarget);
			var id = _this.attr('id');
			var action = 'request_withdraw',method = 'null';
			var success = function(res){
				if(res.success)
					_this.closest('li').remove();
				else
					alert(res.msg);
			}
			window.ajaxSend.Form(event, action, method, success);
			return false;
		},
		actDelJob: function(event){
			var _this = $(event.currentTarget);
			var id = _this.attr('id');
			var data = { ID:id, action: "sync_project",method:"delete"};
			var success = function(res){
				if(res.success)
					_this.closest('li').remove();
				else
					alert(res.msg);
			}
			var res = confirm('Do you want to delete this job?');
			if(res) {
				window.ajaxSend.Custom(data, success);
			}

			return false;
		}
	}


	$(document).ready(function(){
		db_credit.init();
	});
})( jQuery, window.ajaxSend );