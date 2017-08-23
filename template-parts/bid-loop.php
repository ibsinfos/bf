<?php
global $project, $post, $user_ID, $list_bid;
$bid = new BX_Bid();
$bid = $bid->convert( $post );
$_bid_price = $bid->_bid_price;
$commission_fee    = (float) get_commision_fee($_bid_price);
$fre_receive = $_bid_price - $commission_fee;
$bid->fre_receive = get_box_price($fre_receive);
$bid->commission_fee = get_box_price($commission_fee);
$bid->fre_displayname = get_the_author_link();
//$bid->fre_displayname = get_the_author();
$list_bid[$post->ID] = $bid;
$winner = 0;
$bid_class = '';
$winner_text ='';

if ( $bid->post_author == $project->{WINNER_ID} ) {
	$winner = 1;
	$bid_class = 'bid-winner';
	$winner_text = __('Winner','boxtheme');
}

?>
<div class ="col-md-12 row-bid-item bid-item <?php echo $bid_class;?>">
	<div class="col-md-2 no-padding-right">
		<?php echo  get_avatar($bid->post_author); ?>
		<label class="full"><center><?php  echo $winner_text;?></center></label>
	</div>
	<div class ="col-md-10 padding-right-zero">
		<?php
		$list_dealine  = list_dealine();
		if(empty($bid->_dealine))
			$bid->_dealine = 0;
		?>
		<div class="full clear block">
			<h5 class="bid-title inline f-left"><a class="author-url" href="<?php echo get_author_posts_url($bid->post_author , get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?> </a> - </h5>
			<h5 class="bid-title inline f-left"><?php echo $bid->professional_title;?></h5>
		</div>
		<div class="full clear bid-content">
			<?php the_content(); ?>
		</div>
		<div class="full clear">
			<small><?php _e('Deadline: ','boxtheme'); echo isset( $list_dealine[$bid->_dealine]) ? $list_dealine[$bid->_dealine] : '';?> </small>
			<?php if ($project->post_author == $user_ID || current_user_can( 'manage_options' )) { ?>
				<small><?php printf(__(' - Price: %s','boxtheme'), get_box_price($bid->_bid_price )) ?></small>
			<?php } ?>
			<small><?php printf(__('Date: %s','boxtheme'), get_the_date() ); ?></small>
		</div>
		<?php if( $user_ID == $project->post_author && $project->post_status == 'publish' ){ ?>
			<div class="full clear align-right">
				<?php
				$cvs_id = is_sent_msg($project->ID, $bid->post_author);
				if( !$cvs_id || $cvs_id == null ){
					$cvs_id = 0;
				}
				echo "<input type='hidden' name='cvs_id' class='cvs_id' value ='".$cvs_id."' />";
				echo "<input type='hidden' name='bid_author' class='bid_author'  value ='".$bid->post_author."' />";
				if( $cvs_id ){ ?>
					<button class="btn btn-view-conversation btn-act-message " ><?php _e('Send message','boxtheme');?></button>
				<?php } else { ?>
					<button class="btn btn-create-conversation  btn-act-message " ><?php _e('Send message','boxtheme');?></button>
				<?php } ?>
			 	<button class="btn inline btn-status-display no-radius btn-toggle-award" id="<?php echo $bid->ID;?>"><?php _e('Award','boxtheme');?></button>

			</div>
		<?php } else { ?>

		<?php }?>
	</div>

	<div class="col-md-12">

		<form class="frm-award123 hide" >
			<div class="form-group row">
		 		<label  class="col-sm-4 col-form-label"><?php _e('Total amount','boxtheme');?></label>
	      		<div class="col-sm-8">
	      			<?php echo $bid->{BID_PRICE};?> ($)
	      			<p><small><?php printf(__('System auto deducts %s in your balance.','boxtheme'),$bid->{BID_PRICE});?></small></p>
	      		</div>
			</div>
			<div class="form-group row">
		 		<label  class="col-sm-4 col-form-label"><?php _e('Message','boxtheme');?></label>
		 		<div class="col-sm-8">
		 			<textarea name="cvs_content" class="full " rows="3" placeholder="<?php _e('Leave a message to winner','boxtheme');?>"></textarea>
		 		</div>
	 		</div>

			<input type="hidden" name="freelancer_id" value="<?php echo $bid->post_author;?>">
			<input type="hidden" name="project_id" value="<?php echo $bid->post_parent;?>">
			<input type="hidden" name="bid_id" value="<?php echo $bid->ID;?>">
			<br />
			<button type="submit" class="btn btn-award-job align-right f-right no-radius"><?php _e('Award job','boxtheme');?></button>
		</form>
	</div>
</div>