<?php


/**
 * attr_options
	 * errmode
	 	* => errmode_silent | errmode_warning | errmode_exception
 * 	
	 * default_fetch_mode 
	 	* => fetch_obj | fetch_assoc | fetch_both | fetch_named | fetch_num
 *
	 * case
	 	* => case_upper | case_lower |  case_natural
 *
 */

$db['use_now'] = 'def';

$db['def'] = array(
	'host' => 'localhost',
	'port' => '3307',
	'dbname' => 'velk',
	'user' => 'root',
	'pass' => '',
	'attr_options' => [
		'errmode' => 'errmode_exception',
		'default_fetch_mode' => 'fetch_obj',
		'case' => 'case_natural'
	]
);
