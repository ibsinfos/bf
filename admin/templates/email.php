<?php
global $main_page;

$email_link 	= add_query_arg('section','email', $main_page);

$group_option ="email";
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
   	<div class="sub-section " id="payment">
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
       			echo '<tr><td>'.$label[$key].'<td>'.$mail->subject.'</td><td>'.$mail->receiver.'</td><td><a href="'.$edit_link.'"><span class="glyphicon glyphicon-cog"></span></a></td></tr>';
       		}
       		?>
       	</table>
   	</div>
</div>