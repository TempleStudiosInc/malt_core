<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Facebook extends Controller_Website {
	
	public function action_channel()
	{
		$cache_expire = 60*60*24*365;
		header("Pragma: public");
		header("Cache-Control: max-age=".$cache_expire);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$cache_expire) . ' GMT');
		echo '<script src="//connect.facebook.net/en_US/all.js"></script>';
		die();
	}
}