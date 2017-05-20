<?php
/**
 *	Template Name: Page history
 */
?>
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="profile" class="col-md-8">
				<?php

				$role 			= bx_get_user_role();
				$profile_id 	= get_user_meta($user_ID,'profile_id', true);
				$profile 		= BX_Profile::get_instance()->convert($profile_id);
				$current_user 	= wp_get_current_user();
				//echo '<pre>';
				//var_dump($profile);
				//echo '</pre>';

				if($role == FREELANCER){
					get_template_part( 'template-parts/profile/list-bid', 'status' );
				} else {
					get_template_part( 'template-parts/profile/list-project', 'status' );
				}
				?>

			</div> <!-- end left !-->
			<div class="col-md-4">
				<?php get_sidebar('single');?>
				<?php get_sidebar('history');?>
			</div>
		</div>
	</div>
</div>

<?php get_footer();?>

