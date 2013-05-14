<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	// Enable the API browser.  TRUE or FALSE
	'api_browser'  => TRUE,

	// Enable these packages in the API browser.  TRUE for all packages, or a string of comma seperated packages, using 'None' for a class with no @package
	// Example: 'api_packages' => 'Kohana,Kohana/Database,Kohana/ORM,None',
	'api_packages' => TRUE,

	// Enables Disqus comments on the API and User Guide pages
	'show_comments' => Kohana::$environment === Kohana::PRODUCTION,

	// Leave this alone
	'modules' => array(

		// This should be the path to this modules userguide pages, without the 'guide/'. Ex: '/guide/modulename/' would be 'modulename'
		'tscore' => array(

			// Whether this modules userguide pages should be shown
			'enabled' => TRUE,
			
			// The name that should show up on the userguide index page
			'name' => 'Temple Studios Core',

			// A short description of this module, shown on the index page
			'description' => 'Harbinger of fucking doom.',
			
			// Copyright message, shown in the footer for this module
			'copyright' => '&copy; Temple Studios',
		)	
	),

	// Set transparent class name segments
	'transparent_prefixes' => array(
		'Kohana' => TRUE,
	)
);
