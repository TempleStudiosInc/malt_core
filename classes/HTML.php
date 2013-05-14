<?php defined('SYSPATH') or die('No direct script access.');

class HTML extends Kohana_HTML {
	public static function less($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
    	$file = HTML::fix_link($file);
		
        if (strpos($file, '://') === FALSE)
        {
            // Add the base URL
            $file = URL::base($protocol, $index).$file;
        }
        else
        {
            $protocol = 'http';
            $https = Arr::get($_SERVER, 'HTTPS', 'off');
            if ($https == 'on')
            {
                $protocol = 'https';
            }
            $file = str_replace('http', $protocol, $file);
        }
        
        // Set the stylesheet link
        $attributes['href'] = $file;

        // Set the stylesheet rel
        $attributes['rel'] = 'stylesheet/less';

        // Set the stylesheet type
        $attributes['type'] = 'text/css';

        return '<link'.HTML::attributes($attributes).' />';
    }
	
    public static function style($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
    	$file = HTML::fix_link($file);
		
        if (strpos($file, '://') === FALSE)
        {
            // Add the base URL
            $file = URL::base($protocol, $index).$file;
        }
        else
        {
            $protocol = 'http';
            $https = Arr::get($_SERVER, 'HTTPS', 'off');
            if ($https == 'on')
            {
                $protocol = 'https';
            }
            $file = str_replace('http', $protocol, $file);
        }
        
        // Set the stylesheet link
        $attributes['href'] = $file;

        // Set the stylesheet rel
        $attributes['rel'] = 'stylesheet';

        // Set the stylesheet type
        $attributes['type'] = 'text/css';

        return '<link'.HTML::attributes($attributes).' />';
    }
    
    public static function image($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
    	$https = Arr::get($_SERVER, 'HTTPS', 'off');
    	$file = HTML::fix_link($file);
		
        if (strpos($file, '://') === FALSE)
        {
            // Add the base URL
            $file = URL::base($protocol, $index).$file;
        }
        else
        {
            $protocol = 'http';
            if ($https == 'on')
            {
                $protocol = 'https';
            }
            $file = str_replace('http', $protocol, $file);
        }
		
		if ($https !== 'on')
        {
			$file = HTML::cdnify_url($file);
		}
		
		// Add the image link
        $attributes['src'] = $file;

        return '<img'.HTML::attributes($attributes).' />';
    }
	
	public static function script($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
	{
		$file = HTML::fix_link($file);
		
		if (strpos($file, '://') === FALSE)
		{
			// Add the base URL
			$file = URL::site($file, $protocol, $index);
		}
		
		// Set the script link
		$attributes['src'] = $file;

		// Set the script type
		$attributes['type'] = 'text/javascript';

		return '<script'.HTML::attributes($attributes).'></script>';
	}
	
	public static function link($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
	{
		$file = HTML::fix_link($file);
		
		if (strpos($file, '://') === FALSE)
		{
			// Add the base URL
			$file = URL::site($file, $protocol, $index);
		}
		
		$attributes['src'] = $file;
		
		return '<link'.HTML::attributes($attributes).'></script>';
	}
	
	public static function fix_link($file)
	{
		if (strpos($file, '/media/') === 0 OR strpos($file, 'media/') === 0)
		{
			$file = str_replace('media/', '_media/', $file);
		}
		return $file;
	}
	
	public static function cdnify_url($url)
	{
		if (strstr($url, Kohana::$config->load('amazon.media_bucket')) !== false AND Kohana::$config->load('amazon.cdn', false))
		{
			$cdns = Kohana::$config->load('amazon.cdn');
			
			$cdn_address = $cdns[array_rand($cdns)];
			$old_host = parse_url($url, PHP_URL_HOST);
			$url = str_replace($old_host, $cdn_address, $url);
		}
		return $url;
	}
}