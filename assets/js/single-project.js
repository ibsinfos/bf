( function( $ ) {
var gproject;
var cvs_send, msg_send;

var single_project = {
	init: function() {
		this.project =JSON.parse( jQuery('#json_project').html() );
		gproject = this.project;
		cvs_send = {action: 'sync_conversations',method: '',cvs_content:'', project_id:this.project.ID,freelancer_id:0 };
		msg_send = {action: 'sync_message', method: 'insert',cvs_id:0, msg_content:'' };

		$( '#bid_form' ).on( 'submit', this.submitBid );
		$( ".btn-toggle-bid-form").on('click', this.toggleBidForm);

		$( ".input-price").on('change keyup', this.generate_price);
		$( ".btn-scrol-right").on('click',this.showSendMessageForm);
		$( "form.frm-conversation").live('submit', this.createConversation);

		$( "form.frm-send-message").on('submit', this.sendMessage); // in workspace section
		$( ".btn-toggle-award").on('click',this.showAwardForm);
		$( "form.frm-award").on('submit', this.awardProject);
		$( "span.btn-del-attachment").on('click', this.removeAttachment);
		$( "form#frm_emp_review").on('submit', this.reviewFreelancer);
		$( "form#frm_fre_review").on('submit', this.reviewEmployer);


		msg_send.cvs_id = $("#cvs_id").val();
		if($("#container_msg").length) {
			var textarea = document.getElementById('container_msg');
			textarea.scrollTop = textarea.scrollHeight;
		}
		var height = $("body").css("height")-100;

		$("#frame_chat").css('height',height);
		var view = this;

		var uploader = new plupload.Uploader({
		    runtimes : 'html5,flash,silverlight,html4',
		    browse_button : 'pickfiles', // you can pass in id...
		    container: document.getElementById('container_file'), // ... or DOM Element itself
		    url : bx_global.ajax_url,
		    filters : {
		        max_file_size : '10mb',
		        mime_types: [
		            {title : "Image files", extensions : "jpg,gif,png,jpeg,ico,pdf,doc,docx,zip,excel,txt"},
		        ]
		    },
		    multipart_params: {
		    	action: 'upload_file',
		    	post_parent: view.project.ID,
		    	project_tile: view.project.post_title,
		    	cvs_id: $("#cvs_id").val(),
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
					    var new_record =  '<li class="inline f-left">' + file.name + ' (' + plupload.formatSize(file.size) + ')<span id ="'+obj.attach_id+'" class="btn-del-attachment hide">(x)</span></li>';
			            $("ul.list-attach").prepend(new_record);
				    } else{
				    	alert(obj.msg);
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
        $(".glyphicon-star").click(function(event){
        	var _this = $(event.currentTarget);
        	var score = _this.attr('title');
        	$("#rating_scrore").val(score);
        })
	},

	submitBid: function(event){
		var action = "sync_bid", method = "insert";
		var successRes = function(res){
        	if ( res.success ){
        		console.log(success);
        		window.location.reload(true);
	        } else {
	        	alert(res.msg);
	        }
	    }
		window.ajaxSend.Form(event, action, method, successRes);
		return false;

	},
	toggleBidForm: function(event){

		$("#bid_form").slideToggle("slow");
		var _this = $(event.currentTarget);
	},

	showSendMessageForm: function(event){
		var _this = $(event.currentTarget);



		//if( _this.hasClass('.btn-toggle-message') ){
			var cvs_id = _this.attr('id');
			var data = {action: 'sync_msg', method: 'get_converstaion', id:cvs_id};
			var content = '';
			var success = function(res){
				$.each( res.data, function( key, msg ) {
					content = content + msg.msg_content + '<br />';
				});
				$("#frame_chat").html(content);
			}
			var beforeSend = function(event){
				$('#frame_chat').toggleClass('nav-view');
				console.log('loading');
			}
			window.ajaxSend.customLoading(data,beforeSend,success);


	        // var freelancer_id = _this.attr('alt');
	        // var bid_form = wp.template("bid_form");
	        // cvs_send.freelancer_id = freelancer_id;
	        // $("#frame_chat").html(bid_form);
	        // $('#frame_chat').toggleClass('nav-view');
	    //}


	},
	showAwardForm: function(event){
		var _this = $(event.currentTarget);
       // _this.closest('.row').find('.frm-award').toggleClass('hide');
        var cvs_id = _this.attr('id');
			var data = {action: 'sync_msg', method: 'get_converstaion', id:cvs_id};
			var content = '';
			var success = function(res){
				$.each( res.data, function( key, msg ) {
					content = content + msg.msg_content + '<br />';
				});
				$("#frame_chat").html(content);
			}
			var beforeSend = function(event){
				$('#frame_chat').toggleClass('nav-view');
				$("#frame_chat").html(' Show information of this user here');
				console.log('loading');
			}
        window.ajaxSend.customLoading(data,beforeSend,success);
	},
	createConversation: function(e){
		var _this = $(event.currentTarget);
		console.log(_this);
		cvs_send.cvs_content = _this.find(".cvs_content").val();
		var success = function(res){
	        console.log(res);
        	if ( res.success ){
	        } else {
	        	alert(res.msg);
	        }
		}
		cvs_send.method = 'insert';

		window.ajaxSend.Custom(cvs_send, success);
		return false;
	},

	sendMessage: function(e){
		var action = 'sync_message', method = 'insert';
		var success = function(res){
        	if ( res.success ){
        		var record = '<div class="msg-record msg-item row"><div class="col-md-12">';
        		record = record + '<span class="msg-author f-left col-md-2"> &nbsp; </span> <span class="msg-content col-md-10">' + res.msg;
        		record = record + '</span></div></div>';
        		$("#container_msg").append( record );
        		var textarea = document.getElementById('container_msg');
				textarea.scrollTop = textarea.scrollHeight;
        		$("form.send-message").trigger("reset");
	        } else {
	        	alert(res.msg);
	        }
		}
		var _this = $(event.currentTarget);
		console.log(_this);
		msg_send.msg_content = _this.find(".msg_content").val();
		console.log(msg_send);
		window.ajaxSend.Custom(msg_send, success);

		//window.ajaxSend.Form(event, action, method, success);
		return false;
	},

	awardProject: function(event){
		var action = 'award_project', method = 'award';
		var success = function(res){
	        console.log(res);
        	if ( res.success ){
        		console.log('award');
        		window.location.reload(true);
	        } else {
	        	console.log('faile');
	        	alert(res.msg);
	        }
		}
		window.ajaxSend.Form(event, action, method, success);
		return false;
	},
	removeAttachment: function (event){
		event.preventDefault();
		var form = $(event.currentTarget),
			id 	= form.attr('id');

		var success = function(res){
        	if ( res.success ){
        		form.closest("li").remove();
	        } else {
	        	alert(res.msg);
	        }
		}
		var data = {id: id, action: 'sync_attachment',method:'remove'}
		window.ajaxSend.Custom(data, success);
		return false;
	},
	reviewFreelancer: function(event){
		var action = 'sync_review', method = 'review_fre';
		var success = function(res){
	        console.log(res);
        	if ( res.success ){
        		window.location.reload(true);
	        } else {
	        	alert(res.msg);
	        }
		}
		window.ajaxSend.Form(event, action, method, success);
		return false;
	},
	reviewEmployer: function(event){
		var action = 'sync_review', method = 'review_emp';
		var success = function(res){
	        console.log(res);
        	if ( res.success ){
        		window.location.reload(true);
	        } else {
	        	alert(res.msg);
	        }
		}

		window.ajaxSend.Form(event, action, method, success);
		return false;
	},


	load_more_bid: function(e){

	},
	generate_price: function(e){
		var input = $(e.currentTarget);
		if( input.attr('name') == '_bid_price'){
			var total = parseFloat(this.value).toFixed(2);
			var fee = 0.1*total;
			var receive = total - fee.toFixed(2);
			$("#fee_servicce").val(fee.toFixed(2));
			$("#_bid_receive").val(receive.toFixed(2));
		} else  if( input.attr('name') == '_bid_receive'){
			var receive = parseFloat(this.value).toFixed(2);
			var total 	= 100*receive/90;
			var fee = total.toFixed(2) - receive;
			$("#_bid_price").val(total.toFixed(2));
			$("#fee_servicce").val(fee.toFixed(2));
		}
	},
}

	$(document).ready(function(){
		single_project.init();
	})
})( jQuery,window.ajaxSend );