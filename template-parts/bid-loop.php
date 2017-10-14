<?php
global $project, $post, $user_ID, $list_bid, $cms_setting, $bidding;

$bid = new BX_Bid();
$bid = $bid->convert( $post );


$_bid_price = $bid->_bid_price;

$pay_ifo = box_get_pay_info($_bid_price);

$bid->emp_pay = get_box_price($pay_ifo->emp_pay);
$bid->fre_receive = get_box_price($pay_ifo->fre_receive);
$bid->commission_fee = get_box_price($pay_ifo->cms_fee);
$bid->fre_displayname = get_the_author_link();
//$bid->fre_displayname = get_the_author();
$list_bid[$post->ID] = $bid;
$winner = 0;
$bid_class = '';
$winner_text ='';

if ( $bid->post_author == $project->{WINNER_ID} ) {
	$winner = 1;
	$bid_class = 'bid-winner';
	$winner_text = '<i class="fa fa-trophy" aria-hidden="true"></i>';
}

?>
<div class ="col-md-12 row-bid-item bid-item <?php echo $bid_class;?>">
	<div class="col-md-2 no-padding-right text-center col-avatar">
		<?php echo  get_avatar($bid->post_author); ?>
		<?php  echo $winner_text;?>
	</div>
	<div class ="col-md-7 ">
		<?php
		$list_dealine  = list_dealine();
		if( empty($bid->_dealine) )
			$bid->_dealine = 0;
		?>
		<div class="full clear block">
			<h5 class="bid-title inline f-left"><a class="author-url" href="<?php echo get_author_posts_url($bid->post_author , get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?> </a> </h5>
			<h5 class="bid-title inline f-left  primary-color"> - <?php echo $bid->professional_title;?></h5>
		</div>

		<div class="full clear">
			<span><?php _e('Duration: ','boxtheme'); echo isset( $list_dealine[$bid->_dealine]) ? $list_dealine[$bid->_dealine] : '';?> </span>
			<?php if ( $project->post_author == $user_ID || current_user_can( 'manage_options' ) ) { ?>

			<?php } ?>
			<span><?php printf(__('Date: %s','boxtheme'), get_the_date() ); ?></span>
		</div>
		<div class="full clear bid-content">
			<?php the_content(); ?>
		</div>
		<?php if( $user_ID == $project->post_author && $project->post_status == 'publish' ){ ?>
			<div class="full clear align-right">
				<?php
				$cvs_id = is_sent_msg($project->ID, $bid->post_author);
				if( !$cvs_id || $cvs_id == null ){
					$cvs_id = 0;
				}
				echo "<input type='hidden' name='cvs_id' class='cvs_id' value ='".$cvs_id."' />";
				?>
			</div>
		<?php } else if ( $bidding && $bidding->ID == $bid->ID ) { // show cancel bid for current freelancer .
			echo '<div class="full"><a class="btn-del-bid" rel="'.$bidding->ID.'">'.__('CANCEL (X)','boxtheme').' &nbsp;</a></div>';
		}?>
	</div>
	<div class ="col-md-2 no-padding-left padding-right-zero text-center">
		<span><?php printf(__(' %s','boxtheme'), get_box_price($bid->_bid_price )) ?></span>		<?php
			echo "<input type='hidden' name='bid_author' class='bid_author'  value ='".$bid->post_author."' />";
			if( $cvs_id ){ ?>
				<button class="btn-view-conversation btn-act-message primary-color"><img src="<?php echo get_template_directory_uri().'/img/chat.png';?>" /> <?php _e('Send Message','boxtheme');?></button>
			<?php } else { ?>
				<button class="btn-create-conversation  btn-act-message primary-color" ><img src="<?php echo get_template_directory_uri().'/img/chat.png';?>" /> <?php _e('Send Message','boxtheme');?></button>
			<?php } ?>
		 	<button class="inline btn-status-display no-radius btn-toggle-award primary-color" id="<?php echo $bid->ID;?>"> <i class="fa fa-thumbs-o-up primary-colo" aria-hidden="true"></i> <?php _e('Hire Freelancer','boxtheme');?></button>

	</div>
</div>