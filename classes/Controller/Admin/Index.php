<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Index extends Controller_Admin_Website {

	public function before()
	{
		$this->page_title = '';
		
		parent::before();
	}
	
	public function action_index()
	{
		$this->template->content_title = 'Dashboard';
		
		$view = View::factory('admin/index');
		
		$params = array(
			'date_range' => date('Y-m-d', strtotime('today -7 days')).' - '.date('Y-m-d', strtotime('now'))
		);
		$top_pages = ORM::factory('Pageview')->top_pages(10);
		$view->top_pages = $top_pages;
		
		$params = array(
			'group_by' => 'day',
			'date_range' => date('Y-m-01', strtotime('now')).' - '.date('Y-m-d', strtotime('now'))
		);
		$pageviews_stats = ORM::factory('Pageview')->get_pageviews($params);
		$view->pageviews_stats = $pageviews_stats;
		
		$visitor_stats = array();
		foreach ($pageviews_stats as $stat)
		{
			$visitor_stats[$stat->date_viewed_group] = (int) $stat->view_count;
		}
		$visitor_chart = View::factory('admin/stats/bar_graph');
		$visitor_chart->chart_title = 'Page Views - This Month';
		$visitor_chart->stats = $visitor_stats;
		$view->visitor_chart = $visitor_chart;
        
        // Users
        $users = ORM::factory('User')->count_all();
        $view->users = $users;
        
        $oauth_users = ORM::factory('Oauthuser')->select(array(DB::expr('COUNT(id)'), 'oauth_user_count'))->group_by('oauth_type')->find_all();
        $view->oauth_users = $oauth_users;
        
        // Media
        $media_counts = ORM::factory('Asset')->select(array(DB::expr('COUNT(id)'), 'media_count'))->where('user_type', '=', 'admin')->group_by('type')->find_all();
		$view->media_counts = $media_counts;
        
        $file_count = ORM::factory('File')->count_all();
        $view->file_count = $file_count;
        
		$this->template->body = $view;
	}

	public function ajax_stats_pageviews()
	{
		
	}
} // End Index
