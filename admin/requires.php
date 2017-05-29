<?php
if ( ! defined( 'ABSPATH' ) ) exit;
require('admin.php');
require('credit.php');
require('ajax_register.php');
if( class_exists( 'BX_Admin') )
	new BX_Admin();
new BX_Credit_Setting();
