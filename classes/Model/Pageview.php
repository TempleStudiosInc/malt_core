<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Pageview extends ORM {

	public $excludes = array(
		'/store/add_to_cart',
		'/share/load_sharing',
		'/comment/load_comments',
		'/store/checkout_submit',
		'/customer_auth/process_login'
	);
	
	public function top_pages($results = 10, $params = array())
	{
		$date_range = Arr::get($params, 'date_range', false);
		
   		$top_pages_query = DB::select('page_url')
   			->select(DB::expr('COUNT(id) AS view_count'))
   			->from('pageviews');
		foreach ($this->excludes as $exclude)
		{
			$top_pages_query->where('page_url', 'NOT LIKE', '%'.$exclude.'%');
		}
		
		if ($date_range)
		{
			$date_range = explode(' - ', $date_range);
			$start_date = date('Y-m-d 00:00:00', strtotime($date_range[0]));
			$end_date = date('Y-m-d 23:59:59', strtotime($date_range[1]));
			$top_pages_query->where('date_viewed', 'BETWEEN', array($start_date, $end_date));
		}
		
   		$top_pages_query = $top_pages_query->group_by('page_url')
   			->order_by('view_count', 'desc')
			->limit($results);
		$top_pages = $top_pages_query->execute();
		return $top_pages;
	}
	
	public function get_pageviews($params = array())
	{
		$pages = Arr::get($params, 'pages', false);
		$group_by = Arr::get($params, 'group_by', 'month');
		$date_range = Arr::get($params, 'date_range', false);
		
		$page_views = ORM::factory('Pageview');
		$page_views->select(DB::expr('COUNT(id) AS view_count'));
		if ($pages)
		{
			if (is_array($pages))
			{
				$page_views->where_open();
				foreach ($pages as $page)
				{
					$page_views->or_where('page_url', 'LIKE', '%'.$page.'%');
				}
				$page_views->where_close();
			}
			else
			{
				$page_views->where('page_url', 'LIKE', '%'.$pages.'%');
			}
		}
		foreach ($this->excludes as $exclude)
		{
			$page_views->where('page_url', 'NOT LIKE', '%'.$exclude.'%');
		}
		
		switch ($group_by)
		{
			case 'year':
				$page_views->select(DB::expr('DATE_FORMAT(date_viewed, "%Y") AS date_viewed_group'));
				$page_views->group_by(DB::expr('YEAR(date_viewed)'));
				break;
			default:
			case 'month':
				$page_views->select(DB::expr('DATE_FORMAT(date_viewed, "%m-%Y") AS date_viewed_group'));
				$page_views->group_by(DB::expr('YEAR(date_viewed)'));
				$page_views->group_by(DB::expr('MONTH(date_viewed)'));
				break;
			case 'week':
				$page_views->select(DB::expr('DATE_FORMAT(date_viewed, "%m-%d-%Y") AS date_viewed_group'));
				$page_views->group_by(DB::expr('WEEK(date_viewed)'));
			case 'day':
				$page_views->select(DB::expr('DATE_FORMAT(date_viewed, "%m-%d-%Y") AS date_viewed_group'));
				$page_views->group_by(DB::expr('YEAR(date_viewed)'));
				$page_views->group_by(DB::expr('MONTH(date_viewed)'));
				$page_views->group_by(DB::expr('DAY(date_viewed)'));
				break;
			case 'hour':
				$page_views->select(DB::expr('DATE_FORMAT(date_viewed, "%l%p") AS date_viewed_group'));
				$page_views->group_by(DB::expr('YEAR(date_viewed)'));
				$page_views->group_by(DB::expr('MONTH(date_viewed)'));
				$page_views->group_by(DB::expr('DAY(date_viewed)'));
				$page_views->group_by(DB::expr('HOUR(date_viewed)'));
				break;
		}
		
		if ($date_range)
		{
			$date_range = explode(' - ', $date_range);
			$start_date = date('Y-m-d 00:00:00', strtotime($date_range[0]));
			$end_date = date('Y-m-d 23:59:59', strtotime($date_range[1]));
		}
		
		$page_views->where('date_viewed', 'BETWEEN', array($start_date, $end_date));
		
		$page_views = $page_views->find_all();
		return $page_views;
	}
}