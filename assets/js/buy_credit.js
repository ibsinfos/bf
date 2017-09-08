( function( $ ) {
	$(document).ready(function(){
		var  packages =JSON.parse( jQuery('#json_packages').html() );

		$("form.frm-buy-credit").submit(function(event){
			var action ='buy_credit';
			var method = '';
			var _this = $(event.currentTarget);


			var success = function(res){
				console.log(res.success);
				if(res.success){
					window.location.href = res.redirect_url;
				}
			}
			window.ajaxSend.Form(event,action,method,success);
			return false;
		});

		$(".btn-select").click(function(event){
			var _this = $(event.currentTarget);

			_this.closest('.step').find('.record-line').removeClass('activate');
			_this.closest('.record-line').addClass('activate');
			var numItems = $('div.activate').length;

			var key = _this.attr('id');
			var price = packages[key].price;
			console.log(key);
			console.log(price);

			if(price == 0 || price == 'null'){
				$('.radio-gateway-item').prop('disabled', true);
				//$(".rad")
				$("button.btn-submit").removeClass('disable');
			}

			if ( numItems > 1 ) {
				$("button.btn-submit").removeClass('disable');
			}
		});

	});
})( jQuery, window.ajaxSend );