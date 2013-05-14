<?php
	return array(
	    'username' => array(
	        'not_empty' => 'You must provide a username.',
	        'min_length' => 'The username must be at least :param2 characters long.',
	        'max_length' => 'The username must be less than :param2 characters long.',
	        'unique' => 'This username (:param2) is not available.',
	    ),
	    'email' => array(
	    	'not_empty' => 'You must provide a valid email address.',
	    	'unique' => 'This email (:param2) is already registered.',
		),
	    'password' => array(
	        'not_empty' => 'You must provide a password.',
	    ),
	    'password_confirm' => array(
	    	'_external' => 'Password repeat must be the same as password.'
		)
	);