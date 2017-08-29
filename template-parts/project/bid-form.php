<?php
/**
 * keyword bid-form.php,bid_form
 */

global $project, $class_bidded, $bidding;
$budget = (float) $project->_budget;

?>
<form id="bid_form" class="bid-form" <?php echo $class_bidded;?>>
    <h2> <?php _e('Bid on project','boxtheme');?></h2>
   	<div class="form-group row bd-bottom">
      	<label  class="col-sm-8 col-form-label"><?php _e('Price <span class="f-right">$</span','boxtheme');?>></label>
      	<div class="col-sm-4">
        <?php

        $pay_ifo = box_get_pay($budget);
        $cms_fee = $pay_ifo->cms_fee;
        $emp_pay = $pay_ifo->emp_pay;
        $fre_receive = $pay_ifo->fre_receive;

        $label_text = __('Freelancer pay this fee','boxtheme');

        if( $emp_pay > $budget ) {
        	$label_text = __('Employer pay this fee','boxtheme');
        }
?>
        <input type="number" size="6" class="form-control inline input-price" id="_bid_price" name="_bid_price" aria-describedby="" placeholder="<?php _e('Your budget','boxtheme');?>" value="<?php echo $budget;?>">
      </div>
   	</div>
   	<div class="form-group row bd-bottom">
      	<label for="inputEmail3" class="col-sm-8 col-form-label"><?php _e('Fee service','boxtheme');?> <span class="tooltip" title="<?php echo $label_text;?>">?</span>  <span class="f-right">$</span> </label>
      	<div class="col-sm-4">
         	<input type="text" class="form-control" readonly id="fee_servicce" placeholder="<?php _e('Fee service','boxtheme');?>" value="<?php echo $cms_fee;?>" />
      	</div>
   	</div>
   	<div class="form-group row bd-bottom">
      	<label for="inputEmail3" class="col-sm-8 col-form-label"><?php _e('You\'ll receive','boxtheme');?> <span class="f-right">$</span></label>
      	<div class="col-sm-4">
        	<input type="text" class="form-control input-price" id="_bid_receive" name="_bid_receive" value="<?php echo $fre_receive;?>" />
      	</div>
    </div>

   	<div class="form-group">
      <label for="exampleTextarea"><?php _e('Cover Letter','boxtheme');?></label>
      <textarea class="form-control no-radius" id="post_content" required name="post_content" rows="8"><?php if($bidding) echo $bidding->post_content;?></textarea>
   	</div>

   	<div class="form-group">
      	<label for="bid_dealine">Dealine</label>
      	<select class="form-control" id="bid_dealine" name="_dealine">
	        <?php
	        $list = list_dealine();
	        foreach ($list as $key => $value) { ?>
	          <option value="<?php echo $key;?>"> <?php echo $value;?> </option>
	        <?php } ?>
      	</select>
   	</div>
   	<?php wp_nonce_field( 'sync_bid', 'nonce_bid_field' ); ?>
   	<div class="form-group hide">
      	<label for="attach_file"><?php _e('Attachments (optional)','boxtheme');?></label>
      	<input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
      	<small id="fileHelp" class="form-text text-muted"><?php _e('Send this file to project\'s owner.','boxtheme');?></small>
  	</div>
  	<button type="submit" class="btn f-right btn-bid"> &nbsp; <?php if($class_bidded) _e('Update','boxtheme'); else _e('Bid','boxtheme');?> &nbsp;</button>
  	<input type="hidden"  name="post_parent" value="<?php echo $project->ID; ?>" />
</form>
<?php
if($class_bidded){
    echo '<br />';
}
?>