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
	        	_this.closest(".row").remove();

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
			var success = function(event){
				var html ='';

			};
			window.ajaxSend.Form(event, action, method, success);
			return false;
		});

		$(".btn-delete").click(function(event){
			var _this = $(event.currentTarget);
			var action = 'del-post';
			var data = {id: ''};
			data.id = _this.closest(".btn-act-wrap").attr('id');
			window.ajaxSend.Remove(data, action, _this);
			return false;
		});
		if (typeof(tinyMCE) != "undefined") {
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

	});

})(jQuery, window.ajaxSend);