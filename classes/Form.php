<?php

class Form extends Kohana_Form {
    public static function file_image($name, $value = '')
    {
        $view = self::template('upload', $name, $value);
        $view->type = 'image';
        return $view;
    }
    
    public static function file_raw($name, $value = '')
    {
        $view = self::template('upload', $name, $value);
        $view->type = 'raw';
        return $view;
    }
	
	public static function file_video($name, $value = '')
    {
        $view = self::template('upload', $name, $value);
        $view->type = 'video';
        return $view;
    }
	
	public static function file_audio($name, $value = '')
    {
        $view = self::template('upload', $name, $value);
        $view->type = 'audio';
        return $view;
    }
	
	public static function file_all($name, $value = '')
    {
        $view = self::template('upload', $name, $value);
        $view->type = 'all';
        return $view;
    }
	
	public static function select_search($name, $value = '')
    {
        $view = self::template('select_search', $name, $value);
        $view->type = 'blog_posts';
        return $view;
    }
	
	public static function toggle($name, $value)
	{
		return self::template('toggle', $name, $value);
	}
	
	public static function datetime($name, $value)
	{
		return self::template('datetime', $name, $value);
	}
	
	public static function date($name, $value)
	{
		return self::template('date', $name, $value);
	}

	public static function time($name, $value)
	{
		return self::template('time', $name, $value);
	}
	
	public static function tags($name, $value)
	{
		return self::template('tags', $name, $value);
	}
	
	public static function categories($name, $values, $value)
	{
		$view = View::factory('content/admin/form/categories');
		$view->name = $name;
		$view->values = $values;
        $view->value = $value;
        return $view;
	}
	
	public static function image_upload_universal($name, $value = '', $controller, $user_type, $urlredirect)
    {
        $view = View::factory('content/universal_upload');
        $view->type = 'image';
		$view->name = $name;
		$view->controller = $controller;
		$view->urlredirect = $urlredirect;
		$view->user_type = $user_type;
		$view->value = $value;
        return $view;
    }
	
	public static function ajax_file_image($name, $value = '')
    {
        $view = self::template('ajax_upload', $name, $value);
        $view->type = 'image';
        return $view;
    }
	
	public static function group($name, $value)
	{
        return self::template('group', $name, $value);
	}
	
	public static function template($view, $name, $value)
	{
		$view = View::factory('content/admin/form/'.$view);
		$view->name = $name;
        $view->value = $value;
        return $view;
	}
}