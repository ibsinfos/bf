<h2> <?php _e('Config Escrow system','boxtheme');?> </h2> <br />
<form style="max-width: 600px;">
	<div class="form-group row">
		<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Commistion','boxtheme');?></label>
		<div class="col-md-8">
		<input class="form-control" type="text" value="10" id="example-text-input">
		</div>
	</div>
	<div class="form-group row">
		<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Commistion type','boxtheme');?></label>
		<div class="col-md-8">
			<select class="form-control" id="exampleSelect2">
				<option value="emp"><?php _e('Fix number','boxtheme');?></option>
				<option value="fre"><?php _e('Percent','boxtheme');?></option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Who is pay commision','boxtheme');?></label>
		<div class="col-md-8">
			<select class="form-control" id="exampleSelect2">
				<option value="emp">Employer</option>
				<option value="fre">Freelancer</option>
				<option value="share">50/50</option>

			</select>
		</div>
	</div>
	<!-- <div class="form-group row">
		<div class="col-md-12 align-right">
			<button type="submit" class="btn btn-submit"> Save</button>
		</div>
	</div> -->

</form>