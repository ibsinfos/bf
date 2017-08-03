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

						$alphas=range("A","Z");
						$text = array();
						foreach($alphas as $char){
							$text[$char] = array();
						}

						$terms = get_terms( 'project_cat' );
						if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
						    foreach ( $terms as $term ) {
						        $first_letter = strtoupper(substr(trim($term->name) , 0, 1));
						        array_push($text[$first_letter], $term);
						    }
						}

						foreach ($text as $key => $terms) {
							//var_dump($key);
							if( !empty($terms) ){
								echo '<div class="col-md-3"><ul class="none-style"><li>'.$key.'</li>';
								foreach ($terms as $term) {
									echo '<li>'.$term->name.'</li>';
								}
								echo '</ul></div>';
							}
						}
					?>
				</div>
			</div>
		</div>
	</div>
<?php
get_footer();
