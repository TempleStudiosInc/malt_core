<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Auth extends Controller_Admin_Malt_Auth {

	public function action_login()
    {
    	$this->template->content_title = 'Login';
    	parent::action_login();
	}
} // End Auth
