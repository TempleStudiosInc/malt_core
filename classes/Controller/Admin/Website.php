<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin_Website extends Controller_Core {
 
	public $auth_required = array('admin');
    public $page_title;
 
    public function before()
    {
    	$this->application = str_replace('application/', '', APPLICATION);
		if ($this->application != 'admin')
		{
            $this->redirect('/');
			die();
		}
		
    	parent::before();
        
        $session = Session::instance();
        if (isset($_GET) AND ! empty($_GET) AND ! $this->request->is_ajax())
        {
            $admin_get = array();
            $admin_get[$this->requested_controller][$this->requested_action] = $_GET;
            $session->set('admin_get', $admin_get);
        }
        
        if (Arr::get(Arr::get($session->get('admin_get'), $this->requested_controller), $this->requested_action) AND ! $this->request->is_ajax())
        {
            $_GET = Arr::get(Arr::get($session->get('admin_get'), $this->requested_controller), $this->requested_action);
        }
        
		ksort($this->navigation);
		$home_navigation = $this->navigation['home'];
		unset($this->navigation['home']);
		$this->navigation = array_merge(array('home' => $home_navigation), $this->navigation);
		
		$sidebar = View::factory('admin/templates/default/sidebar');
		$sidebar->user = $this->user;
		$sidebar->requested_controller = str_replace('Admin_', '', $this->requested_controller);
		$sidebar->navigation = $this->navigation;
		$this->template->sidebar = $sidebar;
		
		$this->requested_controller = str_replace('Admin_', '', $this->requested_controller);
		
		$sidebar_navigation = Kohana::$config->load('navigation.admin_sidebar.'.strtolower($this->requested_controller));
		$sidebar_navigation_view = View::factory('admin/templates/default/sidebar_navigation');
        $sidebar_navigation_view->requested_controller = $this->requested_controller;
        $sidebar_navigation_view->requested_action = $this->requested_action;
        $sidebar_navigation_view->sidebar_navigation = $sidebar_navigation;
		$this->template->sidebar_navigation = $sidebar_navigation_view;
    }
}