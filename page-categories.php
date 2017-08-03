<?php
/**
 *	Template Name: List categoires
 *	@keyword: page-categories.php
 */

global $wp_query, $ae_post_factory, $post, $user_ID;
$query_args = array(
	'post_type'   => PROJECT,
	'post_status' => 'publish'
);
$loop       = new WP_Query( $query_args );
get_header();
?>
	<div class="full">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php
						$terms = get_terms( 'project_cat', array(
						    'orderby'    => 'name',
						    'hide_empty' => 0
						) );
						echo '<div class="full">';
						echo '<h2 class="col-md-12"> Style 1</h2>';
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){

							echo '<ul class="none-style">';
							foreach ($terms as $key => $term) {
								echo '<li class="col-md-3">'.$term->name.'</li>';
							}
							echo '</ul>';
						} else{

							echo ' Empty';
						}
						echo '</div> <!-- full !-->';

						$terms = get_terms( 'project_cat',array( 'hide_empty' => 0) );

						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){

							echo '<div class="full ">';
							echo '<h2 class="col-md-12"> Style 2</h2>';
							$alphas=range("A","Z");
							$text = array();
							foreach($alphas as $char){
								$text[$char] = array();
							}

						    foreach ( $terms as $term ) {
						        $first_letter = strtoupper(substr(trim($term->name) , 0, 1));
						        array_push($text[$first_letter], $term);
						    }

						    foreach ($text as $key => $terms) {

								if( !empty($terms) ){
									echo '<div class="col-md-3"><ul class="none-style"><li>'.$key.'</li>';
									foreach ($terms as $term) {
										echo '<li>'.$term->name.'</li>';
									}
									echo '</ul></div>';
								}
							}
							echo '</div>';
						}


					?>
				</div>
			</div>
		</div>
	</div>
<?php
get_footer();
