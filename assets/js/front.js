( function( $ ) {

	var front = {
		init: function() {
			$('#signup' ).on( 'submit', this.submitSignup);
			$('form.sign-in').on('submit',this.signIn);
			$('.toggle-menu' ).on( 'click', this.toggleMenu);
			$( "#search_type").on( 'change',this.setSearchUrl);
			//$( ".pagination").on('click',this.pagingProject);
			var view = this;
			$(".menu-hamburger").click(function(){
				var wrap = $(this).closest(".col-nav");

				if( wrap.hasClass('visible')) {
					wrap.toggleClass('default');

				} else {
					console.log('no activate');
					wrap.toggleClass('visible');
				}

			});
			$(".toggle-check").click(function(event){
				var block = $(this).closest(".block");
				var display =block.find("ul").css( "display" );
				console.log(display);
				block.find("ul").slideToggle(300);
				if(display=='block'){
					$(this).removeClass('glyphicon-menu-down cs');
					$(this).addClass('glyphicon-menu-right cs ');
				} else {
					$(this).addClass('glyphicon-menu-down cs');
					$(this).removeClass('glyphicon-menu-right cs');
				}
			});
			$(".btn-adv").click(function(event){
				$(".search-adv").slideToggle(300);
			});
			$(".toggle-fgp").click(function(){

				$(".sign-in").slideUp(300);
				$(".forgot-pass").slideToggle(300);
			});
			$(".toggle-signup").click(function(){

				$(".sign-in").slideDown(300);
				$(".forgot-pass").slideUp(300);
			});
			$(".toggle-msg").click(function(){
				$(".ul-notification").slideToggle(300);
			});

			$(window).scroll(function() {
		    var height = $(window).scrollTop();
		    console.log(height);
		    if(height  > 101) {
		    	$("#full_header").addClass('fixed');
		    } else {
		    	$("#full_header").removeClass('fixed');
		    }
		});



		},

		toggleMenu: function(event){
			var _this = $(event.currentTarget);
			$(".profile-menu").toggleClass('hide');
		},
		signIn: function(event){
			var action = 'bx_signin', method ='';
			var success =  function(res){

	        	if ( res.success ){
	        		if( res.redirect_url  )
	        			window.location.href = res.redirect_url;
	        		else
	        			window.location.reload(true);
		        } else {
		        	alert(res.msg);
		        }
	        };
	        console.log('Sign in');
	        window.ajaxSend.Form(event,action,method,success);
			return false;
		},
		submitSignup: function(event){
			var action = 'bx_signup', method = 'insert';
			var success =  function(res){
	        	if ( res.success ){
	        		window.location.href = res.redirect_url;
		        } else {
		        	alert(res.msg);
		        }
	        };
	        window.ajaxSend.Form(event,action,method,success);
			return false;
		},
		setSearchUrl : function(event){
			var _this = $(event.currentTarget);
			var status = $('option:selected',this).attr('alt');
			$("form.frm-search").attr('action',_this.val() );
			$("input#keyword").attr('placeholder', status );
		},


	}


	$(document).ready(function(){
		front.init();
		var searchForm = {keyword:'',from:0,to:1000,skills:{},cats:{},paged:1,href:0};
		var list = [0,1,2.5,5,10,20,50,100,200,1000];
		var check = 0;
		searchForm.keyword = $("#keyword").val();

		if($("#range").length) {
			$("#range").ionRangeSlider({
	            min: 0,
	            max: 100000,
	            type: 'double',
	            postfix: "k",
	            values: list,
	            onChange:function(data){

	            	var from = data.from;
			    	var to = data.to;
			    	searchForm.to = list[to];
			    	searchForm.from = list[from];
			    	window.ajaxSend.Search(searchForm);
	            },
	        });
	    }

		$(".search_skill").on("click", function(event){
			var element = $(event.currentTarget);
			element.closest('label').toggleClass('activate');
			var check 	= $(this).is(":checked");
			var skill 	= $(this).val();
			var pos 	= $(this).attr('alt');
		    if(check) {
		       searchForm.skills[pos] = skill;
		    } else {
				//delete searchForm.skills.skill;
				delete searchForm.skills[pos];
		    }
		    searchForm.paged = 1;
		    window.ajaxSend.Search(searchForm);

		});
		$(".search_cat").on("click", function(event){
			var element = $(event.currentTarget);
			element.closest('label').toggleClass('activate');
			var check 	= $(this).is(":checked");
			var cat 	= $(this).val();
			var pos 	= $(this).attr('alt');
		    if( check ) {
		       searchForm.cats[pos] = cat;
		    } else {
				//delete searchForm.skills.skill;
				delete searchForm.cats[pos];
		    }
		    searchForm.paged = 1;
		    window.ajaxSend.Search(searchForm);
		});
		$('.pagination1').on('click', function(){
			window.ajaxSend.Search(searchForm);
			return false;
		});
		$(document).on('click', '.list-project .pagination' , function(event) {
			var _this = $(event.currentTarget)
			var paged = _this.html();
			var href = _this.attr('href');
			searchForm.paged=paged;
			searchForm.href= href;
		    window.ajaxSend.Search(searchForm);
			return false;
		});

	});


})( jQuery, window.ajaxSend );