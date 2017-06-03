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
	        	console.log('Insert message');
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
	        	console.log('submit Project');
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
	        		$("#ajax_result").append(res.job_found);
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
					 	//window.location.hash.substring(1);
					}
				}
	        },
	    });
	};

})(jQuery, window.ajaxSend);