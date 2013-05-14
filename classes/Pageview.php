<?php defined('SYSPATH') or die('No direct script access.');

class Pageview {
    
	public static function get_view_count_by_url($url = false)
	{
		if ($url == false)
		{
			$url = Request::detect_uri();
		}
		
		$pageviews = ORM::factory('Pageview')->where('page_url', '=', $url)->count_all();
		
		$view = View::factory('pageview/embed/count');
		$view->view_count = $pageviews;
		$view->uri_id = md5($url);
		return $view;
	}
}