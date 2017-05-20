( function( $ ) {
	$(document).ready(function(){
		$("form.frm-buy-credit").submit(function(event){
			var action ='buy_credit';
			var method = '';
			var success = function(res){
				console.log(res.success);
				if(res.success){
					window.location.href = res.redirect_url;
				}
			}
			window.ajaxSend.Form(event,action,method,success);
			return false;
		});
	});
})( jQuery, window.ajaxSend );