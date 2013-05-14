<?php
	$application  = str_replace('application/','', APPLICATION);
	
	Route::set('auth', '<action>', array('action' => '(login|logout)'))
	    ->defaults(array(
	    'controller' => $application.'_auth'
	));
	
	Route::set('legal', '<action>', array('action' => '(privacy|terms)'))
	    ->defaults(array(
	    'controller' => 'legal'
	));
	