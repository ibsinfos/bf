var ajaxSend = {};
( function( $ ) {
	window.ajaxSend.Form = function(event, action, method, success){
		var form 	= $(event.currentTarget),
			data   	= {};
	    form.find(' input[type=text], input[type=hidden],input[type=email], input[type=number], input[type=date],input[type=password],  input[type=checkbox],textarea,select').each(function() {
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
	        	console.log('beforeSend');
	        },
	        success: success,
	    });
	    return false;
	};
	window.ajaxSend.awardJob = function(event, project_id, success){
		var form 	= $(event.currentTarget),
			data   	= {};
	    form.find(' input[type=text], input[type=hidden],input[type=email], input[type=number], input[type=date],input[type=password],  input[type=checkbox],textarea,select').each(function() {
	    	var key 	= $(this).attr('name');
	        data[key] 	= $(this).val();
	    });


	    $.ajax({
	        emulateJSON: true,
	        method :'post',
	        url : bx_global.ajax_url,
	        data: {
	                action: 'award_project',
	                request: data,
	                method : 'award',
	        },
	        beforeSend  : function(event){
	        	console.log('beforeSend');
	        },
	        success: success,
	    });
	    return false;
	};
	window.ajaxSend.submitPost = function(data, action, method, successRes){

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
	        	console.log('beforeSend submit Project');
	        },
	        success: successRes,
	    });
	    return false;
	};

	window.ajaxSend.Custom = function(data, success){
	    $.ajax({
	        emulateJSON: true,
	        method :'post',
	        url : bx_global.ajax_url,
	        data: {
	                action: data.action,
	                request: data,
	                method : data.method,
	        },
	        beforeSend  : function(event){
	        	console.log('Insert message');
	        },
	        success: success,
	    });
	    return false;
	};

	window.ajaxSend.customLoading = function(data, beforeSend, success){
	    $.ajax({
	        emulateJSON: true,
	        method :'post',
	        url : bx_global.ajax_url,
	        data: {
	                action: data.action,
	                request: data,
	                method : data.method,
	        },
	        beforeSend  : beforeSend,
	        success: success,
	    });
	    return false;
	};
	window.ajaxSend.Search = function(data){

		if( window.ajaxSend.template == null ){
			window.ajaxSend.template = wp.template( 'project-record' );
		}

	    $.ajax({
	        emulateJSON: true,
	        method :'post',
	        url: bx_global.ajax_url,
	        data: {
                action: 'sync_search',
                request: data,
	        },
	        beforeSend  : function(event){
	        	//$("#ajax_result").addClass('loading');
	        },
	        success: function(res){
	        	$("#ajax_result").html('');
	        	if( res.job_found ){
	        		$("#count_results").html(res.job_found);
	        	}
	        	$.each(res.result, function (index, value) {

					$("#ajax_result").append( window.ajaxSend.template( value ) );
				});
				//$("#ajax_result").removeClass('loading');
				if( res.pagination ){
					$("#ajax_result").append( res.pagination );

					if( data.href ){
					 	window.location.hash = data.href; // update the url
					 	window.location.hash.split('#')[1];
					}
				}
	        },
	    });
	};

	function createBtnUpload(id, btn, step_name){
		var uploader= new plupload.Uploader({
			    runtimes: 'html5,gears,flash,silverlight,browserplus,html4',
                multiple_queues: true,
                multipart: true,
                urlstream_upload: true,
                multi_selection: false,
                upload_later: false,

			    browse_button : btn, // you can pass in id...
			    container: document.getElementById(id), // ... or DOM Element itself
			    url : ae_globals.ajaxURL,
			    filters : {
			        max_file_size : '10mb',
			        mime_types: [
			            {title : "Image files", extensions : "jpg,gif,png,jpeg,ico,pdf,doc,docx,zip,excel,txt"},
			        ]
			    },
			    multipart_params: {
			    	action: 'upload_file',
			    	target:'add_portfolio',


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
			        	console.log(file);
			        	console.log(obj);
					    if(obj.success){
						    var new_record =  '<img src="' + obj.file.guid +  '" />';
						    console.log(obj.file);
						    console.log(obj);

				            $("#pickfiles").append(new_record);

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
	}

})(jQuery, window.ajaxSend);