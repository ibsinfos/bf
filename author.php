<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >
			<div class="bg-section">
				<div id="author-view" class=" author-view">
					<div class="full bd-bottom">
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
							$skill_text = join( "", $draught_links );
						}
						?>
				    	<div class="col-md-3 update-avatar">
				    		<?php
				    		$url = get_user_meta($author_id,'avatar_url', true);
				    		if ( ! empty($url ) ){ echo '<img class="avatar" src=" '.$url.'" />';}
				    		else {	echo get_avatar($author_id);	}
				    		?>
				    	</div>
				      	<div class="col-md-9 no-padding-left">
				      		<div class="col-md-10 no-padding"><h1 class="profile-title no-margin"> <?php echo $profile->post_title;?></12></div>
				      		<div class="col-md-2 no-padding align-right">
				      			<span class="absolute1 top right align-right hour-rate">$<?php echo $profile->hour_rate;?>/hr</span>
				      		</div>
				      		<div class="full clear">
				        	<h4 class="professional-title no-margin primary-color" ><?php echo !empty ($profile->professional_title) ? $profile->professional_title : __('Empty professinal title','boxtheme');?></h4>
				        	</div>
				        	<div class="full">
				        		<span class="clear block author-address"><?php echo $profile->address;?></span>
				        		<span class="clear author-skills"><?php echo $skill_text;;?></span>
				        	</div>
				      	</div>
			      	</div> <!-- .full !-->

					<!-- Ovreview line !-->
					<div class="full bd-bottom">
						<div class="col-sm-8 text-justify">

							<h3>  <?php printf(__('Overviews','boxtheme'), $profile->post_title);?></h3>
							<div class="full author-overview"><?php echo $profile->post_content;?></div>
							<?php
							//$video_id = get_post_meta($profile->ID, 'video_id', true);
							$video_id = '';
							if( !empty($video_id)){ ?>
								<div class="video-container">
								  <iframe width="635" height="315" src="https://www.youtube-nocookie.com/embed/<?php echo $video_id;?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
								</div>
							<?php } ?>
						</div>
						<div class="col-md-4">
							<h3>Profile info</h3>
							<ul class="work-status">
								<?php
								$projects_worked = get_user_meta($author_id,PROJECTS_WORKED, true);
								$earned = get_user_meta($author_id, EARNED, true);
								$pcountry = get_the_terms( $profile_id, 'country' );
								if( !$projects_worked ){
									$projects_worked = 0;
									$earned = 0;
								}
								?>
								<li><label> Job worked: </label> <?php echo  $projects_worked;?></li>
								<li><label> Total earn: </label><?php  echo $earned;?></li>
								<li><label>Country:</label><?php if( !empty($pcountry) ){ echo $pcountry[0]->name; } ?></li>
						      	<li><label> Language:</label> English </li>
							</ul>
						</div>
					</div><!-- End Ovreview !-->
				</div> <!-- .end author-view !-->
			</div> <!-- end bg section !-->

			<!-- Line work history !-->
			<div class="bg-section">
				<div class="col-md-8">
					<div class="header-title"><h3> <?php _e('Work History and Feedback','boxtheme');?></h3></div>
					<?php

					$args = array(
						'post_type' 	=> BID,
						'author' 		=> $author_id,
						'post_status' 	=> DONE,
					);
					$result =  new WP_Query($args);

					if( $result->have_posts() ){ ?>
						<div class ="full-width" >
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
							} ?>

						</div> <!-- end list_bidding !-->
						<?php bx_pagenate($result);

					} else {
						echo '<p>';
						echo '<br />';
						_e('There is not any feedback','boxtheme');
						echo '</p>';
					}?>
				</div>
				<div class="col-md-4 p-activity">
					<div class="header-title"><h3 class=""> &nbsp;</h3></div>
					<br />
					<p><label> Profile link</label> <br /><a class="nowrap" href="<?php the_permalink($profile_id);?>"><?php the_permalink($profile_id);?></a></p>
					<p><label>Activity</label> <br /> <span>24X7 hours</span></p>
				</div>
			</div>

			<!-- end history + feedback line !-->
			<!-- Line portfortlio !-->

				<?php
				$args = array(
						'post_type' 	=> 'portfolio',
						'author' 		=> $author_id,
					);
				$result =  new WP_Query($args);
				$i = 0;

				if( $result->have_posts() ){ ?>
					<div class="bg-section">
					<div class="col-md-12"> <div class="header-title"><h3> Portfolio </h3></div></div>
					<div class="col-md-12">
					<?php

					while ($result->have_posts()) {
						$class = "middle-item";
						if($i %3 == 0)
							$class = "no-padding-left";
						if($i%3==2)
							$class = "no-padding-right";

						$result->the_post();
						echo '<div class="col-md-4 port-item '.$class.'">';
							the_post_thumbnail('full' );

						echo '</div>';
						$i++;
					}
					echo '</div>';
					echo '</div>';
				} else {
					echo '<p>';
						echo '<br />';
						//_e('Portfolio is empty.','boxtheme');
						echo '</p>';
				}
				?>
		</div>
	</div>
<?php get_footer();?>

