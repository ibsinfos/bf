
<div class="full search-adv">

	<div class="block full">
		<h3> Countries  <span class=" toggle-check glyphicon  pull-right glyphicon-menu-down"></span></h3>
		<ul class="list-checkbox ul-cats">
			<?php
				$countries = get_terms( array(
	                'taxonomy' => 'country',
	                'hide_empty' => false,
	            ) );
	            if ( ! empty( $countries ) && ! is_wp_error( $countries ) ){
	                foreach ( $countries as $key=>$country ) {
	                   echo '<li><label class="skil-item"> <input type="checkbox" name="country" class="search_country" alt="'.$key.'"  value="' . $country->term_id . '">' . $country->name . '<span class="glyphicon glyphicon-ok"></span></label></li>';
	                }
	            }
	     	?>
	    </ul>
	</div>
	<div class="block full">
		<h3> Skills <span class="toggle-check glyphicon  pull-right glyphicon-menu-down"></span></h3>

	 	<ul class="list-checkbox ul-skills">

			<?php
				$skills = get_terms( array(
	                'taxonomy' => 'skill',
	                'hide_empty' => true,
	            ) );
	            if ( ! empty( $skills ) && ! is_wp_error( $skills ) ){
	                foreach ( $skills as $key=>$skill ) {
	                   	echo '<li><label class="skil-item"> <input type="checkbox" name="skill" class="search_skill" alt="'.$key.'" value="' . $skill->term_id . '">' . $skill->name . '<span class="glyphicon glyphicon-ok"></span></label></li>';
	                }
	             }
	         ?>
	 	</ul>
	</div>
		<?php if( current_user_can('manage_option') ){ ?>

	 	<ul class="list-checkbox ul-status">
			<li><h3> Profile status</h3><small>Admin only</small></li>
			<li><label> <input type="checkbox" name="post_status" class="post_status" alt="0"  value="publish"> Publish</label></li>
			<li><label> <input type="checkbox" name="post_status" class="post_status" alt="1"  value="pending"> Pending</label></li>
			<li><label> <input type="checkbox" name="post_status" class="post_status" alt="2"  value="awarded"> Awarded</label></li>
			<li><label> <input type="checkbox" name="post_status" class="post_status" alt="3"  value="'done"> Done</label></li>
			<li><label> <input type="checkbox" name="post_status" class="post_status" alt="4"  value="'disputing"> Disputing</label></li>
			</ul>
		 <?php } ?>

		<input type="hidden" name="post_type" id="post_type" value="profile">
</div> <!-- end search adv !-->
	<button class="btn btn-adv full mobile-only no-radius"> Advance Filter</button>

