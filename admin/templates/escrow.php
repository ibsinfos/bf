
<?php
// group = escrow
// section = commision
//
$group_option = "escrow";
$option = BX_Option::get_instance();
$escrow = $option->get_group_option($group_option);
$commision = $escrow->commision;
$number = 10;
$type = 'fix';
$user_pay = 'fre';
if( isset( $commision->number ) ){
	$number = $commision->number;
}
if( isset( $commision->type ) ){
	$type = $commision->type;
}
if( isset( $commision->user_pay ) ){
	$user_pay = $commision->user_pay;
}
?>

<div class="sub-section " id="<?php echo $group_option;?>" >
	<h2> <?php _e('Config Escrow system','boxtheme');?> </h2> <br />
   	<div class="sub-item" id="commision">
		<form style="max-width: 600px;">
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Commision','boxtheme');?></label>
				<div class="col-md-8"><input class="form-control auto-save" type="number" value="<?php echo $number;?>" name = "number" id="example-text-input"></div>
			</div>
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Commistion type','boxtheme');?></label>
				<div class="col-md-8">
					<select class="form-control auto-save" name="type" id="exampleSelect2">
						<option value="fix" <?php selected( $type, 'emp' ); ?> > <?php _e('Fix number','boxtheme');?></option>
						<option value="percent" <?php selected( $type, 'fre' ); ?> ><?php _e('Percent','boxtheme');?></option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Who is pay commision','boxtheme');?></label>
				<div class="col-md-8">
					<select class="form-control auto-save" name="user_pay" id="exampleSelect2">
						<option value="emp" <?php selected( $user_pay, 'emp' ); ?> >Employer</option>
						<option value="fre"<?php selected( $user_pay, 'fre' ); ?> >Freelancer</option>
						<option value="share" <?php selected( $user_pay, 'share' ); ?> >50/50</option>

					</select>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
$opt_credit = BX_Option::get_instance()->get_group_option('opt_credit');

?>
<div class="sub-section " id="opt_credit" >
	<h2> <?php _e('Credit System','boxtheme');?> </h2> <br />
   	<div class="sub-item" id="opt_credit">
		<form style="max-width: 600px;">
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Number Credit Auto Deposit for new account','boxtheme');?></label>
				<div class="col-md-8"><input class="form-control auto-save" type="number_credit_default" multi="0" value="<?php echo $opt_credit->number_credit_default;?>" name = "number_credit_default" id="number_credit_default"></div>
			</div>
		</form>
	</div>
</div>