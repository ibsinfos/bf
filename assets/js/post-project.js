( function( $ ) {
	var postProject = {

		init: function() {
			$( '#submit_project' ).on('submit', this.submitProject);
			$(".chosen-select").chosen();
			this.postsubmit = [];
			this.attach_ids = [];
			var view = this;
			var nonce = $("#fileupload-container").find('.nonce_upload_field').val();
			var uploader = new plupload.Uploader({
			    runtimes: 'html5,gears,flash,silverlight,browserplus,html4',
                multiple_queues: true,
                multipart: true,
                urlstream_upload: true,
                multi_selection: false,
                upload_later: false,

			    browse_button : 'sp-upload', // you can pass in id...
			    container: document.getElementById('fileupload-container'), // ... or DOM Element itself
			    url : bx_global.ajax_url,
			    filters : {
			        max_file_size : '10mb',
			        mime_types: [
			            {title : "Image files", extensions : "jpg,gif,png,jpeg,ico,pdf,doc,docx,zip,excel,txt"},
			        ]
			    },
			    multipart_params: {
			    	action: 'box_upload_file',
			    	nonce_upload_field: nonce,

			    },
			    init: {
			        PostInit: function() {


			        },
			        FilesAdded: function(up, files) {
			        	console.log('123');
			        },

			        Error: function(up, err) {
			            document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
			        },
			        FileUploaded : function(up, file, response){
			        	var obj = jQuery.parseJSON(response.response);
					    if(obj.success){

						    var new_record =  '<li class="">' + file.name +  '<span id ="'+obj.attach_id+'" class="btn-del-attachment hide">(x)</span></li>';
				            $("ul.list-attach").append(new_record);
				            view.attach_ids.push(obj.attach_id);

					    } else{
					    	container.log(obj);
					    }
			        }
			    }
			});
			uploader.init();
			uploader.bind('FilesAdded', function(up, files) {
	        	//view.$el.find("i.loading").toggleClass("hide");
	            up.refresh();
	            up.start();
	        });

		},
		submitProject: function(event) {
			var action = "sync_project", method = "insert";
			var form 	= $(event.currentTarget),
				data   	= {};
		    form.find('input:not(radio:checked),textarea,select').each(function() {
		    	var key 	= $(this).attr('name');
		        data[key] 	= $(this).val();
		    });

		    form.find('input:radio:checked').each(function() {
		    	var key 	= $(this).attr('name');
		        data[key] 	= $(this).val();
		    });

		    data.attach_ids = postProject.attach_ids;

			var successRes =  function(res){
	        	if ( res.success ){
	        		window.location.href = res.redirect_url;
		        } else {
		        	alert(res.msg);
		        }
	        };
			window.ajaxSend.submitPost(data, action, method, successRes);
			return false;
		},

	}
	postProject.init();


})( jQuery, window.ajaxSend );