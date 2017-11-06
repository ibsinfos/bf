<?php

$group_option = "escrow";
$option = BX_Option::get_instance();
$escrow = $option->get_escrow_setting();
$commision = (object) $escrow->commision;
//echo '<pre>';
//var_dump($escrow);
// var_dump($commision);
//echo '</pre>';

?>
<div id="<?php echo $group_option;?>" class="main-group">
	<div class="sub-section " id="commision" >
		<h2> <?php _e('Config Escrow system','boxtheme');?> </h2> <br />
	   	<div class="sub-item" id="commision">
			<form style="max-width: 600px;">
				<div class="form-group row">
					<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Commision','boxtheme');?></label>
					<div class="col-md-8"><input class="form-control auto-save" type="number" value="<?php echo $commision->number;?>" name = "number" min="1"  level="1" step="any" id="example-text-input"></div>
				</div>
				<div class="form-group row">
					<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Commistion type','boxtheme');?></label>
					<div class="col-md-8">
						<select class="form-control auto-save" name="type" id="exampleSelect2"  level="1">
							<option value="fix" <?php selected( $commision->type, 'emp' ); ?> > <?php _e('Fix number','boxtheme');?></option>
							<option value="percent" <?php selected( $commision->type, 'fre' ); ?> ><?php _e('Percent','boxtheme');?></option>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Who is pay commision','boxtheme');?></label>
					<div class="col-md-8">
						<select class="form-control auto-save" name="user_pay" id="exampleSelect2"  level="1">
							<option value="emp" <?php selected( $commision->user_pay, 'emp' ); ?> >Employer</option>
							<option value="fre"<?php selected( $commision->user_pay, 'fre' ); ?> >Freelancer</option>
							<option value="share" <?php selected( $commision->user_pay, 'share' ); ?> >50/50</option>

						</select>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php
$opt_credit = BX_Option::get_instance()->get_group_option('opt_credit');
$active = 'credit';
if( isset( $active ) && ! empty( $escrow->active ) ){
	$active = $escrow->active;
}

$hide_credit = $hide_pp = '';
if($active == 'credit'){
	$hide_pp = ' hide ';
}
if( $active == 'paypal_adaptive'){
	$hide_credit = ' hide ';
}

?>

<div id="<?php echo $group_option;?>" class="main-group " >
	<label class="form-label">Select the Eccrow system</label>
	<select class="form-control auto-save" name="active">
		<option value="credit" <?php selected( $active,'credit' ) ?> >Credit System</option>
		<option value="paypal_adaptive" <?php selected( $active,'paypal_adaptive' ) ?>>PayPal Adaptive</option>
	</select>
</div>
<div class="sub-section <?php echo $hide_credit;?>" id="opt_credit" >

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
<div class="main-group <?php echo $hide_pp;?>" id="paypal_adaptive" >
	<?php
	$paypal_adaptive = (OBJECT) BX_Option::get_instance()->get_group_option('paypal_adaptive');


	$api_appid = $api_userid = $app_signarute = $api_userpassword = '';

	if( !empty( $paypal_adaptive ) ){
		$api_appid = $paypal_adaptive->api_appid;
		$api_userid = $paypal_adaptive->api_userid;
		$app_signarute = $paypal_adaptive->app_signarute;
		$api_userpassword = $paypal_adaptive->api_userpassword;
	}

	?>
	<h2> <?php _e('PayPal Adaptive Sandbox Mode Settings','boxtheme');?> </h2> <br />
   	<div class="sub-item" id="opt_credit">
		<form style="max-width: 600px;">
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label">API User ID</label>
				<div class="col-md-8"><input class="form-control auto-save" type="text" multi="0" value="<?php echo $api_userid;?>" name = "api_userid" id="api_userid"></div>
			</div>
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label">API Password</label>
				<div class="col-md-8"><input class="form-control auto-save" type="api_userpassword" multi="0" value="<?php echo $api_userpassword;?>" name = "api_userpassword" id="api_userpassword"></div>
			</div>
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label">API Signarute</label>
				<div class="col-md-8"><input class="form-control auto-save" type="text" multi="0" value="<?php echo $app_signarute;?>" name = "app_signarute" id="app_signarute"></div>
			</div>
			<div class="form-group row">
				<label for="example-text-input" class="col-md-4 col-form-label">API App ID</label>
				<div class="col-md-8"><input class="form-control auto-save" type="text" multi="0" value="<?php echo $api_appid;?>" name = "api_appid" id="api_appid"></div>
			</div>
		</form>
	</div>
</div>
