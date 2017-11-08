<?php
/**
 * be included in page-dashboard and list all bidded of current Employer
 * Only available for Employer or Admin account.
**/

	global $user_ID;

	//$status = isset( $_GET['status'] ) ? $_GET['status'] : 'any';
	$status = isset( $_GET['status'] ) ? $_GET['status'] : array('publish','pending','disputing','resolved','done','awarded');
	$loadmore = false;
	$link =  box_get_static_link('dashboard');
	$check = $status;
	if( is_array($status) )
		$check = 'any';

	?>
	<div class="my-project full">
		<div class="col-md-12 heading-top">
			<h1 class="text-center"> <?php _e('My Projects','boxtheme');?> </h1>
			<ul class="tab-heading inline"> <li id="processing" class="active">Processing</li><li id="active">Active</li><li id="other">Other</li></ul>
		</div>
		<?php get_template_part( 'template-parts/dashboard/list-projects', 'processing' ); ?>
		<?php get_template_part( 'template-parts/dashboard/list-projects', 'active' ); ?>
		<?php get_template_part( 'template-parts/dashboard/list-projects', 'other' ); ?>
	</div>

<style type="text/css">
	ul.tab-heading{
		width: 500px;
		margin: 0 auto;
		display: block;
		margin-top: 30px;
	}
	ul.tab-heading li{
		width: 33%;
		display: inline-block;
		font-size: 18px;
		cursor: pointer;
		text-align: center;
		text-transform: uppercase;
	}
	ul.tab-heading li::after{
		height: 15px;
		content: '';
		float: right;
		margin-top: 7px;
		border-right: 2px solid rgb(30, 159, 173);
	}
	ul.tab-heading li.active{
		color: rgb(30, 159, 173);;
	}
	ul.tab-heading li:last-child::after{
		border-right: 0;
	}
	.my-project .heading-top{
		margin-bottom: 35px;
	}
	.ul-list-project{
		display: none;
	}
	.ul-list-project.active{
		display: block;
	}

</style>
<script type="text/javascript">
	(function($){
		$(document).ready( function(){
			$("ul.tab-heading li").click(function(event){
				console.log('123');
				var _this = $(event.currentTarget);
				var id = _this.attr('id');
				$("ul.tab-heading li").removeClass('active');
				_this.addClass('active');

				$(".ul-list-project").removeClass('active')
				$("#ul-"+id).addClass('active');
			});
		});
	})(jQuery);
</script>