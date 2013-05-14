<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Malt_Legal extends Controller_Website {
	
	public function action_privacy()
    {
        $view = View::factory('/legal/privacy_policy');
		$this->template->body = $view;
	}
	
	public function action_terms()
    {
        $view = View::factory('/legal/terms_of_use');
		$this->template->body = $view;
	}
}