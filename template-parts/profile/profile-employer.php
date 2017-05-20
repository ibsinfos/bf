<?php
global $employer_type, $profile_id;

if($employer_type != COMPANY){
	get_template_part( 'template-parts/profile/profile-employer', 'freelancer' );
} else {
	if($profile_id){
		get_template_part( 'template-parts/profile/profile-info', 'company' );
	}
}
?>