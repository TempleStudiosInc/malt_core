<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Config extends Controller_Admin_Website {

	public function before()
	{
		$this->page_title = '';
		
		parent::before();
	}
	
	public function action_index()
	{
		$this->redirect('/admin_config/website');
	}
	
	public function action_website()
	{
	    $group = 'website';
        
        $view = View::factory('config/admin/'.$group);
		
		$post = Arr::get($_POST, $group, null);
		
		if ($post !== null)
		{
			foreach ($post as $key => $value)
			{
				$config = Kohana::$config->load($group);
				$config->set($key, $value);
			}
			Notice::add(Notice::SUCCESS, ucfirst($group).' Config Saved.');
		}
		
		$configs = Kohana::$config->load($group);
        $view->group = $group;
		$view->configs = $configs;
        
		$this->template->body = $view;
	}
	
	public function action_facebook()
	{
		$view = View::factory('config/admin/facebook');
		
		$post = Arr::get($_POST, 'facebook', null);
		
		if ($post !== null)
		{
			foreach ($post as $key => $value)
			{
				$config = Kohana::$config->load('facebook');
				$config->set($key, $value);
			}
			Notice::add(Notice::SUCCESS, 'Facebook Config Saved.');
		}
		
		$configs = Kohana::$config->load('facebook');
		$view->configs = $configs;
		
		$this->template->body = $view;
	}
	
	public function action_twitter()
	{
		$view = View::factory('config/admin/twitter');
		
		$post = Arr::get($_POST, 'twitter', null);
		
		if ($post !== null)
		{
			foreach ($post as $key => $value)
			{
				$config = Kohana::$config->load('twitter');
				$config->set($key, $value);
			}
			Notice::add(Notice::SUCCESS, 'Twitter Config Saved.');
		}
		
		$configs = Kohana::$config->load('twitter');
		$view->configs = $configs;
		
		$this->template->body = $view;
	}
    
    public function action_google()
    {
        $view = View::factory('config/admin/google');
        
        $post = Arr::get($_POST, 'google', null);
        
        if ($post !== null)
        {
            foreach ($post as $key => $value)
            {
                $config = Kohana::$config->load('google');
                $config->set($key, $value);
            }
            Notice::add(Notice::SUCCESS, 'Google Config Saved.');
        }
        
        $configs = Kohana::$config->load('google');
        $view->configs = $configs;
        
        $this->template->body = $view;
    }
    
    public function action_paypal()
    {
        $view = View::factory('config/admin/paypal');
        
        $post = Arr::get($_POST, 'paypal', null);
        
        if ($post !== null)
        {
            foreach ($post as $key => $value)
            {
                $config = Kohana::$config->load('paypal');
                $config->set($key, $value);
            }
            Notice::add(Notice::SUCCESS, 'PayPal Config Saved.');
        }
        
        $configs = Kohana::$config->load('paypal');
        $view->configs = $configs;
        
        $this->template->body = $view;
    }

} // End Config
