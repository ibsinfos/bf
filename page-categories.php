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
<?php get_header(); ?>
<div class="full-width">
	<div class="container site-container">
		<div class="row site-content" id="content" >

				<div class="col-md-12">
					<?php
						$terms = get_terms( 'project_cat', array(
						    'orderby'    => 'name',
						    'hide_empty' => 0
						) );


						echo '<h2 class="col-md-12"> LIST CATEGORIES </h2>';
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
							echo '<div class="full">';
							echo '<ul class="none-style">';
							foreach ($terms as $key => $term) {
								echo '<li class="col-md-3">'.$term->name.'('.$term->count.')</li>';							}
							echo '</ul>';

							echo '</div> <!-- full !-->';
							echo '<div class="full ">';
							echo '<br />';
							echo '<h2 class="col-md-12"> LIST CATEGORIES </h2>';
							$alphas=range("A","Z");
							$text = array();
							foreach($alphas as $char){
								$text[$char] = array();
							}

						    foreach ( $terms as $term ) {
						        $first_letter = strtoupper(substr( trim($term->name) , 0, 1) );
						        if( isset($text[$first_letter]) )
						        	array_push($text[$first_letter], $term);
						    }

						    foreach ($text as $key => $terms) {

								if( !empty($terms) ){
									echo '<div class="col-md-3"><ul class="none-style"><li class="cat-label"><label class="h5">'.$key.'</label></li>';
									foreach ($terms as $term) {
										echo '<li>'.$term->name.'</li>';
									}
									echo '</ul></div>';
								}
							}
							echo '</div>';
						}  else{
							echo ' Empty';
						}


					?>
				</div>
			</div>
		</div>
	</div>
	<style type="text/css">
		li.cat-label label{
			border-bottom: 2px solid #39c515;
			color: #39c515;
		}
	</style>
<?php
get_footer();
