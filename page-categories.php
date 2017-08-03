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
						function box_list_categories($terms, $style = 1){

							if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
								if($style == 1){
									echo '<ul class="none-style">';
									foreach ($terms as $key => $term) {
										$term_link = get_term_link( $term );
										echo '<li class="col-md-3"><a href="'. esc_url( $term_link ) .'">'.$term->name.'('.$term->count.')</a></li>';							}
									echo '</ul>';
								} else if($style == 2) {

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
												$term_link = get_term_link( $term );
												echo '<li><a href="'. esc_url( $term_link ) .'">'. $term->name .'</a></li>';
											}
											echo '</ul></div>';
										}
									}
								}

							} else {
								_e('List categories is empty','boxtheme');
							}
						}

						$terms = get_terms( 'project_cat', array(
						    'orderby'    => 'name',
						    'hide_empty' => 0
						) );




						echo '<div class="full">';
							echo '<h2 class="col-md-12"> LIST CATEGORIES STYLE 1 </h2>';
							box_list_categories($terms);
						echo '</div> <!-- full !-->';

						echo '<div class="full ">';
							echo '<h2 class="col-md-12"> LIST CATEGORIES STYLE 2</h2>';
							box_list_categories($terms, $style = 2);
						echo '</div>';


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
