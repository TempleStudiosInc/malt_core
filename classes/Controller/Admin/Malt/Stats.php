<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Malt_Stats extends Controller_Admin_Website {
	
	public function action_index()
	{
		$view = View::factory('admin/stats/index');
		
		$facets = array();
		$facet_views = Kohana::list_files('views/admin/stats/facets');
		foreach ($facet_views as $facet_key => $facet_value)
		{
			$facet_name = pathinfo($facet_key, PATHINFO_FILENAME);
			$facets[$facet_name] = ucwords(str_replace('_', ' ', $facet_name));
		}
		asort($facets);
		$view->facets = $facets;
		
		$form = array();
		$form['facet'] = Arr::get($_GET, 'facet', false);
		if ( ! $form['facet'])
		{
			reset($facets);
			$first_key = key($facets);
			$form['facet'] = $first_key;
		}
		$form['date_range'] = Arr::get($_GET, 'date_range', date('Y-m-01', strtotime('now')).' - '.date('Y-m-d', strtotime('now')));
		$view->form = $form;
		
		$params = array(
			'group_by' => 'day',
			'date_range' => $form['date_range']
		);
		
		$facet_view = View::factory('admin/stats/facets/'.$form['facet']);
		$facet_view->params = $params;
		$view->facet_view = $facet_view;
		
		$this->template->body = $view;
	}
}