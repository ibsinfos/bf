var ajaxSend = {};
( function( $ ) {
	window.ajaxSend.Form = function(event, action, method, success){
		var form 	= $(event.currentTarget),
			data   	= {};
	    form.find(' input[type=text], input[type=hidden],  input[type=checkbox],textarea,select').each(function() {
	    	var key 	= $(this).attr('name');
	        data[key] 	= $(this).val();
	    });

	    form.find('input:radio:checked').each(function() {
	    	var key 	= $(this).attr('name');
	        data[key] 	= $(this).val();
	    });

	    $.ajax({
	        emulateJSON: true,
	        method :'post',
	        url : bx_global.ajax_url,
	        data: {
	                action: action,
	                request: data,
	                method : method,
	        },
	        beforeSend  : function(event){
	        	console.log('Insert message');
	        },
	        success: success,
	    });
	    return false;
	};

	window.ajaxSend.Custom = function(data, action){
	    $.ajax({
	        emulateJSON: true,
	        method :'post',
	        url : bx_global.ajax_url,
	        data: {
	                action: action,
	                request: data,
	        },
	        success  : function(event){
	        	console.log('Success msg');
	        	//window.location.reload(true);
	        },
	        beforeSend  : function(event){
	        	console.log('Insert message');
	        },
	    });
	    return false;
	};
	$(document).ready(function(){
		$('.auto-save').change(function(event){
			var _this = $(event.currentTarget);
			var action = 'save-option';
			var data = {section: '',group:'',name:'',value:''};


			data.group  = _this.closest('.section').attr('id');
			data.section = _this.closest('.one-item').attr('id');
			data.name = _this.attr('name');
			data.value = _this.val();
			window.ajaxSend.Custom(data, action);
		});
		$(".frm-add-package").submit(function(event){
			var _this = $(event.currentTarget);
			var action = 'create-packge';
			var method = 'insert';
			var success = function(event){

			};
			window.ajaxSend.Form(event, action, method, success);
			return false;
		});
		$(".btn-delete").click(function(event){
			var _this = $(event.currentTarget);
			var action = 'del-post';
			var data = {id: ''};
			data.id = _this.attr('id');
			window.ajaxSend.Custom(data, action);
			return false;
		})
	});

})(jQuery, window.ajaxSend);