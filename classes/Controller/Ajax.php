<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller_Template {
	
	public $template = 'admin/templates/ajax/layout';
	
	public function action_external_image_browser()
	{
		$this->template->body = View::factory('asset/admin/external_browser');
	}
	
	public function action_ajax_get_image_url()
	{
		$asset_id = Arr::get($_GET, 'asset_id');
		if ($asset_id)
		{
			$asset = ORM::factory('Asset', $asset_id);
			$url = $asset->files->where('type', '=', 'image_large')->find()->url;
			echo $url;
		}
		else 
		{
			echo 'false';
		}
		die;
	} 
} // End Ajax