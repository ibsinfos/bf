<section class="full-width packge-plan">
	<div class="container">
		<div class="row">
			<?php
				wp_reset_query();
				$args = array(
					'post_type' => '_package',
					'posts_per_page' =>3
				);
				$result = new WP_Query($args);
				if( $result->have_posts() ){
					while( $result->have_posts() ){
						$result->the_post();
						$price = get_post_meta(get_the_ID(),'price', true);
						?>
						<div class="col-md-4">
							<div class="pricing-table-plan">
								<header data-plan="basic" class="pricing-plan-header basic-plan">
									<span class="plan-name"><?php the_title();?></span>
								</header>
					    		<div class="plan-features">
					    		<span class="plan-monthly primary-color"><?php box_price($price);?></span>
					    		<span class="pack-des">	<?php the_content();?> </span>
								</div>
					            <a class="btn btn-primary btn-xlarge " href="">TRAIL NOW</a>
							</div>
						</div>
					<?php } ;?>
			<?php } ?>
		</div> <!-- end row !-->
	</div>
</section>