<?php

$group_option = "escrow";
$option = BX_Option::get_instance();
$escrow = $option->get_escrow_setting($group_option);
$commision = (object) $escrow->commision;
// echo '<pre>';
// var_dump($escrow);
// var_dump($commision);
// echo '</pre>';

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