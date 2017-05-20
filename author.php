<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div id="author-view" class="col-md-8 author-view">
				<?php
				global $author_id;
				$author 	= get_user_by( 'slug', get_query_var( 'author_name' ) );
				$author_id = $author->ID;

				$profile_id = get_user_meta($author_id,'profile_id', true);

				$profile 	= BX_Profile::get_instance()->convert($profile_id);
				$skills 	= get_the_terms( $profile_id, 'skill' );
				$skill_text = '';
				if ( $skills && ! is_wp_error( $skills ) ){
					$draught_links = array();
					foreach ( $skills as $term ) {
						$draught_links[] = '<a href="'.get_term_link($term).'">'.$term->name.'</a>';
					}
					$skill_text = join( ", ", $draught_links );
				}
				?>
			    <div class="form-group row">
			    	<div class="col-md-3 update-avatar">
			    		<?php
			    		$url = get_user_meta($author_id,'avatar_url', true);
			    		if ( ! empty($url ) ){ echo '<img class="avatar" src=" '.$url.'" />';}
			    		else {	echo get_avatar($author_id);	}
			    		?>
			    	</div>
			      	<div class="col-md-9 no-padding-left">
			      		<div class="col-md-10 no-padding"><h2 class="profile-title no-margin"> <?php echo $profile->post_title;?></h2></div>
			      		<div class="col-md-2 no-padding align-right">
			      			<span class="absolute1 top right align-right hour-rate">$<?php echo $profile->hour_rate;?>/hr</span>
			      		</div>
			      		<div class="full clear">
			        	<h4 class="professional-title no-margin" ><?php echo !empty ($profile->professional_title) ? $profile->professional_title : __('Empty professinal title','boxtheme');?></h4>
			        	</div>
			        	<div class="full">
			        		<span class="clear block author-address"><?php echo $profile->address;?></span>
			        		<span class="clear author-skills"><?php echo $skill_text;;?></span>
			        	</div>
			      	</div>
			    </div>
				<div class="form-group row">
					<div class="col-sm-12 text-justify">
						<?php
						$video_id = get_post_meta($profile->ID, 'video_id', true);

						if( !empty($video_id)){ ?>
						<div class="video-container">
							  <iframe width="635" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $video_id;?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
						</div>
						<?php } ?>
						<h3>  <?php printf(__('Overviews','boxtheme'), $profile->post_title);?></h3>
						<div class="full author-overview">
							<?php echo $profile->post_content;?>
						</div>

					</div>
				</div>

			</div> <!-- end left !-->
			<div class=" sidebar col-md-4">
				Work History <br />
				<?php
				$projects_worked = get_user_meta($author_id,PROJECTS_WORKED, true);
				$earned = get_user_meta($author_id, EARNED, true);
				if( !$projects_worked ){
					$projects_worked = 0;
					$earned = 0;
				}

				printf(__('%s jobs','boxtheme'),$projects_worked);?><br />

				<?php  printf(__('($)%s earned','boxtheme'), $earned);?><br />


				<ul>
					<li> <span class="glyphicon glyphicon-map-marker"></span>
			      	<?php
						$pcountry = get_the_terms( $profile_id, 'country' );
				      	if( !empty($pcountry) ){
				         echo $pcountry[0]->name;
				      	}
   					?>
			      	</li>
			      	<li>
			      		<h3> <?php _e('Languages','boxtheme');?></h3>
			      		<ul>
			      			<li> English </li>

			      		</ul>
			      	</li>

				</ul>
			</div>
			<div class="col-md-8">
				<h3> <?php _e('Work History and Feedback','boxtheme');?></h3>
				<?php

				$args = array(
					'post_type' 	=> BID,
					'author' 		=> $author_id,
					'post_status' 	=> DONE,
				);
				$result =  new WP_Query($args);

				if( $result->have_posts() ){ ?>
					<div class ="full-width" id="list_bidding">
						<div class="row row-heading">
							<div class="col-md-2 no-padding-right"><?php _e('Date','boxtheme');?> </div>
							<div class="col-md-8"> <?php _e('Description','boxtheme');?>	</div>
							<div class="col-md-2 align-right">	<?php _e('Price','boxtheme');?>	</div>

						</div>
					<?php
					while( $result->have_posts()){
						global $post;
						$result->the_post();
						get_template_part( 'template-parts/profile/list-bid-done', 'loop' );
					}
					echo '</div>';
					bx_pagenate($result);
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer();?>

