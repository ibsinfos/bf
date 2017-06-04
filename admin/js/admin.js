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

	window.ajaxSend.Custom = function(data, action, _this){
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
	        	_this.attr('value',data.value);
	        	//window.location.reload(true);
	        },
	        beforeSend  : function(event){
	        	console.log('Insert message');
	        },
	    });
	    return false;
	};
	$(document).ready(function(){
		$('.auto-save, .wrap-auto-save textarea, iframe ').change(function(event){
			var _this = $(event.currentTarget);
			var action = 'save-option';
			var data = {section: '',group:'',name:'',value:''};


			data.group  = _this.closest('.sub-section').attr('id');
			data.section = _this.closest('.sub-item').attr('id');
			data.name = _this.attr('name');
			data.value = _this.val();
			if( _this.attr('data-toggle') == 'toggle'){
				console.log(data.value);
				if(data.value == '1'){
					console.log('set 0');
					data.value = 0;
				} else {
					data.value = 1;
				}
			}
			console.log(data);
			window.ajaxSend.Custom(data, action, _this);
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
			window.ajaxSend.Custom(data, action, _this);
			return false;
		});
		tinymce.init({
			plugins: "lists",
  			toolbar: "bold italic  link unlink numlist bullist alignleft aligncenter alignright",
  			menubar: "insert",
  			link_assume_external_targets: true,
		  	selector: 'textarea',
		 	//  init_instance_callback: function (editor) {
			//     editor.on('click', function (e) {
			//     });
			// },
			setup : function(ed) {
		    	ed.onChange.add(function(ed, l) {

		        	var _this = $(document.getElementById(ed.id));
		        	if( _this.hasClass('auto-save') ){
						var action = 'save-option';
						var data = {section: '',group:'',name:'',value:''};
						data.group  = _this.closest('.sub-section').attr('id');
						data.section = _this.closest('.sub-item').attr('id');
						data.name = _this.attr('name');
						data.value = tinyMCE.activeEditor.getContent();
						window.ajaxSend.Custom(data, action, _this);
					}

		 	    });
		 	}
		});


	});

})(jQuery, window.ajaxSend);