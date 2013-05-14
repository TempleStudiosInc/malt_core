<?php defined('SYSPATH') OR die('No direct script access.');

class URL extends Kohana_URL {
	public static function get_current_url($type = 'full')
	{
		if ( ! isset($_SERVER))
		{
			return '';
		}
		
		$page_url = '';
		if ($type == 'full' OR $type == 'domain')
		{
			$page_url = 'http';
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
			{
				$page_url .= 's';
			}
			$page_url .= '://';
			
			if ($_SERVER['SERVER_PORT'] != '80')
			{
				$page_url .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
			}
			else
			{
				$page_url .= $_SERVER['SERVER_NAME'];
			}
		}
		
		if ($type == 'full' OR $type == 'uri')
		{
			$page_url .= $_SERVER['REQUEST_URI'];
		}
		
		return $page_url;
	}
}