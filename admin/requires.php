<?php
	require_once dirname(__FILE__) . '/admin.php';
	require_once dirname(__FILE__) . '/credit.php';
	require_once dirname(__FILE__) . '/ajax_register.php';
	if( class_exists( 'BX_Admin') )
 		new BX_Admin();
 	if( class_exists( 'BX_Credit_Setting') )
 		new BX_Credit_Setting();
?>