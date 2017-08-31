<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function bx_swap_button($group, $name, $is_active, $multipe = true){
	$checked  = '';
	$multi =  'multi = "1" ';
	if( $is_active ) $checked = 'checked';
	if( !$multipe ) $multi = 'multi = "0" ';
	echo '<input type="checkbox" class="auto-save" '.$multi.' name="'.$name.'" value="'.$is_active.'" '.$checked.' data-toggle="toggle">';

}



function list_email(){
	return array(
		'new_register' => array(
			'receiver' => 'register',
			'subject' =>	'New register',
			'name' =>	'New register',
			'content' =>	'Has new register'
		),
		'new_job' => array(
			'receiver' => 'admin',
			'subject' =>	'The job %s has been posted',
			'content' =>	'The job %s has been posted'
		),
		'new_bidding' => array(
			'receiver' => 'employer',
			'subject' =>	'New bidding in your project %s',
			'content' =>	'Has new bidding'
		),
		'new_message' => array(
			'receiver' => 'receiver',
			'subject' =>	'Have a new message for you',
			'content' =>	'Hi, Have new message for you.'
		),
		'assign_job' => array(
			'receiver' => 'freelancer',
			'subject' =>	'Your bidding is choosen for project %s',
			'content' =>	'Congart, Your bidding is choosen'
		),
	);
}


	require_once dirname(__FILE__) . '/admin.php';
	require_once dirname(__FILE__) . '/credit.php';
	require_once dirname(__FILE__) . '/ajax_register.php';
	if( class_exists( 'BX_Admin') )
 		new BX_Admin();
 	if( class_exists( 'BX_Credit_Setting') )
 		new BX_Credit_Setting();
?>