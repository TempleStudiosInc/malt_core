<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'admin' => array(
		'home' => array(
			'title' => 'Dashboard',
			'url' => '/',
			'controller' => 'index',
			'permission' => 'admin',
			'icon' => 'icon-dashboard',
		),
		'content' => array(
			'title' => 'Content',
			'url' => '/admin_content',
			'controller' => 'Content',
			'permission' => 'admin',
			'submenu' => array(
				'tag' => array(
					'title' => 'Tags',
					'url' => '/admin_tag',
					'controller' => 'Tag',
					'permission' => 'asset',
					'icon' => 'icon-tags',
				),
			)
		),
		'category' => array(
            'title' => 'Categories',
            'url' => '/admin_category',
            'controller' => 'Category',
            'permission' => 'category'
        ),
		'users' => array(
			'title' => 'Users',
			'url' => '/admin_user',
			'controller' => 'User',
			'permission' => 'user',
			'icon' => 'icon-user',
		),
		'config' => array(
			'title' => 'Config',
			'url' => '/admin_config',
			'controller' => 'Config',
			'permission' => 'config',
			'icon' => 'icon-cog',
		),
		'stats' => array(
			'title' => 'Stats',
			'url' => '/admin_stats',
			'controller' => 'Stats',
			'permission' => 'admin',
			'icon' => 'icon-bar-chart',
		),
	),
	'admin_sidebar' => array(
		'config' => array(
			'website' => 'Website',
			'facebook' => 'Facebook',
			'twitter' => 'Twitter',
			'google' => 'Google',
			'paypal' => 'PayPal',
		),
	),
	
	'sidebar' => array(
		'account' => array(
			'account' => array(
				'title' => 'Edit Account',
				'url' => '/account',
				'controller' => 'Account'
			),
			'account_password' => array(
				'title' => 'Change Password',
				'url' => '/account/password',
				'controller' => 'Account'
			),
			'account_address' => array(
				'title' => 'Addresses',
				'url' => '/account/address',
				'controller' => 'Account'
			),
		)
	)
);