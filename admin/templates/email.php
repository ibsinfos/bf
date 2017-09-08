<?php
global $main_page;

$email_link 	= add_query_arg('section','email', $main_page);

$group_option ="box_mail";
$option = BX_Option::get_instance();
$box_mail = (object)$option->get_mailing_setting();


$list = (object) list_email();
$label = array(
	'new_register' =>'New account register',
	'new_job' => 'New project',
	'new_bidding' => 'New bidding',
	'assign_job' => 'Assign job',
	'new_message' => "New Message",
);
?>
<div class="section box-section" id="<?php echo $group_option;?>">
   	<div class="sub-section " id="email">
       	<h2><?php _e('Email Notifications','boxtheme');?> </h2>
       	<p><?php _e('Email notifications sent from job board are listed below. Click on an email to configure it.','boxtheme');?></p>
       	<table class="widefat">
       		<thead>
					<tr>
					<th class="page-name"><?php _e( 'Name', 'boxtheme' ); ?></th>
						<th class="page-name"><?php _e( 'Subject', 'boxtheme' ); ?></th>
						<th class="page-name"><?php _e( 'Receiver', 'boxtheme' ); ?></th>
						<th class="page-name">&nbsp;</th>
					</tr>
				</thead>
       		<?php
       		foreach ($list as $key=> $email) {
       			$mail = (object)$email;
       			$edit_link = add_query_arg('name',$key, $email_link);
       			echo '<tr><td>'.$label[$key].'<td>'.$mail->subject.'</td><td>'.$mail->receiver.'</td><td><a href="'.$edit_link.'" class="btn-config"><span class="glyphicon glyphicon-cog"></span></a></td></tr>';
       			echo '<tr class="tr-config-cotent hide"> <td colspan = "4" class="td-config-content">';
       			echo '<div class="col-md-12"><input type="text" name="" value="'.$mail->subject.'" /></div>';
       			echo '<div class="col-md-12"><textarea  name="content">'.$mail->content.'</textarea></div>';

       			echo '</td>';
       			echo '</tr>';
       		}
       		?>
       	</table>
   	</div>
   	<p>&nbsp;</p>
   	<h2> <?php _e('Setting email','boxtheme');?> </h2>
   	<div class="sub-section " id="box_mail">

		<div class="full">
		<div class="form-group row">
			<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Header Email Image','boxtheme');?></label>
			<div class="col-md-12"><input class="form-control auto-save" multi="0" type="text" value="<?php echo $box_mail->header_image;?>"  multi="0" name="header_image" id="header_image"></div>
		</div>

		<div class="form-group row">
			<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Main bg color','boxtheme');?></label>
			<div class="col-md-12"><input class="form-control auto-save"   type="text" name="main_bg"  multi="0"  value="<?php echo $box_mail->main_bg;?>" id="main_bg"></div>
		</div>



		<div class="form-group row">
			<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('Footer text','boxtheme');?></label>
			<div class="col-md-12"><input class="form-control auto-save"  multi="0"  type="text" name="footer_text" multi="0"  value="<?php echo $box_mail->footer_text;?>" id="footer_text"></div>
		</div>

		<div class="form-group row">
			<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('From name','boxtheme');?></label>
			<div class="col-md-12"><input class="form-control auto-save"  multi="0"  type="text" name="from_name" multi="0"  value="<?php echo $box_mail->from_name;?>" id="from_name"></div>
		</div>
		<div class="form-group row hide">
			<label for="example-text-input" class="col-md-4 col-form-label"><?php _e('From Address','boxtheme');?></label>
			<div class="col-md-12"><input class="form-control auto-save"  multi="0"  type="text" name="from_address" multi="0"  value="<?php echo $box_mail->from_address;?>" id="from_address"></div>
		</div>


		</div>
	</div>
</div>