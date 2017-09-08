var ajaxSend = {};
( function( $ ) {
	function get_tinymce_content(id) {
	    var content;
	    var inputid = id;
	    var editor = tinyMCE.get(inputid);
	    var textArea = jQuery('textarea#' + inputid);
	    if (textArea.length>0 && textArea.is(':visible')) {
	        content = textArea.val();
	    } else {
	        content = editor.getContent();
	    }
	    return content;
	}

	window.ajaxSend.Form = function(event, action, method, success){
		var form 	= $(event.currentTarget),
			data   	= {};
	    form.find(' input[type=text],input[type=number], input[type=hidden],  input[type=checkbox],textarea,select').each(function() {
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
	window.ajaxSend.formEmail = function(event, action, method, success){
		var form 	= $(event.currentTarget),
			data   	= {};
	    form.find(' input[type=text],input[type=number], input[type=hidden],  input[type=checkbox],textarea,select').each(function() {
	    	var key 	= $(this).attr('name');
	        data[key] 	= $(this).val();
	    });
	    var email_key= form.find('.key-input').val();

	   data['content'] = get_tinymce_content(email_key);

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

	        },
	        beforeSend  : function(event){
	        	console.log('Insert message');
	        },
	    });
	    return false;
	};
	window.ajaxSend.Remove = function(data, action, _this){
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
	        	_this.closest(".row-item").remove();

	        },
	        beforeSend  : function(event){
	        	console.log('Insert message');
	        },
	    });
	    return false;
	};
	window.ajaxSend.Approve = function(data, type, _this){
	    $.ajax({
	        emulateJSON: true,
	        method :'post',
	        url : bx_global.ajax_url,
	        data: {
	                action: 'admin_approve',
	                type: type,
	                request: data,
	        },
	        success  : function(event){

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
			var data = {group:'', section: '', name:'',value:'', multi : 1};

			data.group  = _this.closest('.sub-section').attr('id');
			data.section = _this.closest('.sub-item').attr('id');
			data.name = _this.attr('name');
			data.value = _this.val();
			if( _this.attr('data-toggle') == 'toggle'){
				if(data.value == '1'){
					data.value = 0;
				} else {
					data.value = 1;
				}
			}
			if( _this.attr('multi') == '0' ){
				data.multi = 0;
			}

			window.ajaxSend.Custom(data, action, _this);
		});
		$("#sub_heading_menu a").click(function(){
			var _this = $(event.currentTarget);
			var id = _this.attr('href');
			$(".second-content").removeClass('active');
			$(id).addClass('active');
		})
		$(document).on('submit', '.frm-add-package', function(event){
			var _this = $(event.currentTarget);
			var action = 'create-packge';
			var method = 'insert';
			var ID =  _this.find("#ID").val();
			var success = function(event){

				if(ID != 0){
					_this.remove();
				} else {
					window.location.reload(true);
				}

			};
			window.ajaxSend.Form(event, action, method, success);
			return false;
		});

		$(".btn-delete").click(function(event){
			var _this = $(event.currentTarget);
			var action = 'del-post';
			var data = {id: ''};
			data.id = _this.closest(".btn-act-wrap").attr('id');
			var res = confirm('Are you sure ?');
			if(res) {
				window.ajaxSend.Remove(data, action, _this);
			}
			return false;
		});
		if (typeof(tinyMCE) != "undefined") {
			tinymce.init({
				quicktags: false,
				media_buttons: false,
				tinymce: false,
				wpautop: false,
				plugins: "lists",
	  			toolbar: "bold italic  link unlink numlist bullist alignleft aligncenter alignright",
	  			menubar: "insert",
	  			link_assume_external_targets: true,
			  	selector: 'textarea',

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
		}
		$(".btn-edit-package").click(function(event){
			var _this = $(event.currentTarget);
			var frm_edit = wp.template("frm_edit_package");
			var id =  _this.closest(".btn-act-wrap").attr('id');
			var list_package = JSON.parse( jQuery('#json_list_package').html() );
			var row = _this.closest(".row-item");
			if( row.find('form').length  ){
				row.find('form').remove();
			} else {
				row.append("<div class='col-md-12'>"+ frm_edit(list_package[id]) + "</div>" );
			}

		});
		$(".btn-config").click(function(){
			var _this = $(event.currentTarget);
			$(".tr-config-cotent").addClass('hiden');
			_this.closest('tr').next().toggleClass('hide');


			return false;
		});
		$(".frm-update-mail").submit(function( event ){
			var action = 'save_mail_setup';
			var method ='update';
			var success = function(respond){
				console.log(respond);
			}

			window.ajaxSend.formEmail(event, action, method, success);
			return false;
		})

	});

})(jQuery, window.ajaxSend);