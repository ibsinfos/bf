( function( $ ) {
	var cropper;
	var cropBoxData;
	var canvasData;
	var profile = {
		init: function() {
			$(".frm-avatar").on('submit',this.saveAvatar);

			$( '#update_profile' ).on( 'submit', this.update_profile);
			$( '.update-profile' ).on( 'submit', this.update_profile_meta);
			$( '.update-one-meta' ).on( 'submit', this.updateOneMeta);

			$( ".add-portfolio").on( 'submit',this.addPortfolio);
			$(".chosen-select").chosen();
			$( ".btn-del-port").on( 'click',this.delPortfolio);

			// open modal
			$('.update-avatar img').on('click', function() {
			    $('#modal_avatar').modal('show');
		    });
			var list_portfolio =JSON.parse( jQuery('#json_list_portfolio').html() );
		    var add_portfolio_form = wp.template("add_portfolio");

		    $('.btn-show-portfolio-modal').on('click', function() {
		        $('#modal_add_portfolio').modal('show');
		    });
		    $('.btn-edit-port').on('click', function(event) { // update
		    	var _this = $(event.currentTarget);
		    	var p_id = _this.closest(".port-item").attr('id');
		    	$("#modal_add_portfolio #post_title").val(list_portfolio[p_id].post_title);
		    	$("#modal_add_portfolio #port_id").val(list_portfolio[p_id].ID);
		    	$("#modal_add_portfolio #thumbnail_id").val(list_portfolio[p_id].thumbnail_id);
		    	$("#modal_add_portfolio .wrap-port-img").html("<img src="+list_portfolio[p_id].feature_image +" />");

		        $('#modal_add_portfolio').modal('show');
		    });

			$(".btn-edit-default").click(function(event){
				var form 	= $(event.currentTarget);

				$(".update").toggleClass('hide');
				$(".static").toggleClass('hide');
			});
			$(".btn-edit-second").click(function(event){
				var form 	= $(event.currentTarget);
				form.closest('form').find('.visible-default').toggleClass('invisible');
				form.closest('form').find('.invisible-default').toggleClass('visible');
			});
			$(".btn-edit").click(function(){
				var element 	= $(event.currentTarget);
				element.closest('.block').toggleClass('update');

			});

			var uploader = new plupload.Uploader({
			    runtimes : 'html5,flash,silverlight,html4',
			    browse_button : 'pickfiles', // you can pass in id...
			    container: document.getElementById('modal_add_port'), // ... or DOM Element itself
			    url : bx_global.ajax_url,
			    filters : {
			        max_file_size : '10mb',
			        mime_types: [
			            {title : "Image files", extensions : "jpg,gif,png,jpeg,ico,pdf,doc,docx,zip,excel,txt"},
			        ]
			    },
			    multipart_params: {
			    	action: 'upload_file',
			    	method:'add_portfolio',
			    },
			    init: {
			        PostInit: function() {

			        },
			        FilesAdded: function(up, files) {

			        },

			        Error: function(up, err) {
			            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			        },
			        FileUploaded : function(up, file, response){
			        	var obj = jQuery.parseJSON(response.response);
					    if(obj.success){
						    var new_record =  '<img src="'+obj.file.guid+'">';
						    $("#thumbnail_id").val( obj.attach_id);
				            $("#pickfiles").html(new_record);
					    } else{
					    	alert(obj.msg);
					    }
			        }
			    }
			});
			uploader.init();
			uploader.bind('FilesAdded', function(up, files) {
	            up.refresh();
	            up.start();
	        });
			var uploader = new plupload.Uploader({
			    runtimes : 'html5,flash,silverlight,html4',
			    browse_button : 'btn-upload-avatar', // you can pass in id...
			    container: document.getElementById('full_avatar'), // ... or DOM Element itself
			    url : bx_global.ajax_url,
			    filters : {
			        max_file_size : '10mb',
			        mime_types: [
			            {title : "Image files", extensions : "jpg,gif,png,jpeg,ico,pdf,doc,docx,zip,excel,txt"},
			        ]
			    },
			    multipart_params: {
			    	action: 'upload_file',
			    	method: 'upload_full_avatar',
			    },
			    init: {
			        PostInit: function() {

			        },
			        FilesAdded: function(up, files) {

			        },

			        Error: function(up, err) {
			            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			        },
			        FileUploaded : function(up, file, response){
			        	var obj = jQuery.parseJSON(response.response);
					    if(obj.success){
						    var new_record =  '<img src="'+obj.file.guid+'">';
				            $(".img-container").html(new_record);
					    } else{
					    	alert(obj.msg);
					    }
			        }
			    }
			});
			uploader.init();
			uploader.bind('FilesAdded', function(up, files) {
	            up.refresh();
	            up.start();
	        });

		},
		saveAvatar : function(event){
			var form 	= $(event.currentTarget);
			console.log('123');
			var success = function(res){
				console.log(res);
			}
			window.ajaxSend.Form(event, 'custom_avatar', 'insert', success);

			return false;
		},
		updateOneMeta: function(e){
			var form 	= $(e.currentTarget);
	  		var data   	= {};
	  		var select = {};

            form.find('input, textarea, select').each(function() {
            	var key 	= $(this).attr('name');
                data[key] 	= $(this).val();
            });
	  		$.ajax({
		        emulateJSON: true,
		        method :'post',
		        url : bx_global.ajax_url,
		        data: {
		                action: 'sync_profile',
		                request: data,
		                method : 'update_one_meta',
		        },
		        beforeSend  : function(event){
		        	console.log('bat dau submit job');
		        },
		        success : function(res){
		        	console.log(res);
		        	if ( res.success ){
		        		window.location.reload(true);

			        } else {
			        	//alert(res.msg);
			        }
		        }
	        });
			return false;
		},
		addPortfolio: function(event){

			var success = function(res){
	        	if ( res.success ){
	        		$("#list_portfolio").prepend("<div class='col-md-6 port-item' id='"+res.data.ID+"'><img src='"+res.data.feature_image+"'></div>");
	        		//$('#modal_add_portfolio').modal('show');
	        		$('#modal_add_portfolio').modal('hide');

		        } else {
		        	alert(res.msg);
		        }
			}

			window.ajaxSend.Form(event, 'sync_portfolio', 'insert', success);
			return false;
		},
		delPortfolio: function(e){
			var _this = $(event.currentTarget);
		    var p_id = _this.closest(".port-item").attr('id');

		    window.ajaxSend.Form(event, 'sync_portfolio', 'insert', success);
		    var data = {action:'sync_portfolio',method:'delete',ID:p_id};
		    var success = function(res){
	    		console.log('del ok');
	    		if(res.success){
	    			_this.closest(".port-item").remove();
	    		}

		    }
		    window.ajaxSend.Custom(data, success);
		},


		update_profile: function(e){
			var form 	= $(e.currentTarget);
	  		var data   	= {};
	  		var select = {};

            form.find('input, textarea, select').each(function() {
            	var key 	= $(this).attr('name');
                data[key] 	= $(this).val();
            });
	  		$.ajax({
		        emulateJSON: true,
		        method :'post',
		        url : bx_global.ajax_url,
		        data: {
		                action: 'sync_profile',
		                request: data,
		                method : 'update',
		        },
		        beforeSend  : function(event){
		        	console.log('bat dau submit job');
		        },
		        success : function(res){
		        	console.log(res);
		        	if ( res.success ){
		        		window.location.reload(true);
			        } else {
			        	alert(res.msg);
			        }
		        }
	        });
			return false;
		},

		update_profile_meta: function(e){
			var form 	= $(e.currentTarget);
	  		var data   	= {};
	  		var select = {};

            form.find('input, textarea, select').each(function() {
            	var key 	= $(this).attr('name');
                data[key] 	= $(this).val();
            });
	  		$.ajax({
		        emulateJSON: true,
		        method :'post',
		        url : bx_global.ajax_url,
		        data: {
		                action: 'sync_profile',
		                request: data,
		                method : 'update_profile_meta',
		        },
		        beforeSend  : function(event){
		        	console.log('bat dau submit job');
		        },
		        success : function(res){
		        	console.log(res);
		        	if ( res.success ){
		        		window.location.reload(true);
			        } else {
			        	//alert(res.msg);
			        }
		        }
	        });
			return false;
		}
	}
	profile.init();

})( jQuery, window.ajaxSend );