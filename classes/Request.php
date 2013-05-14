<?php defined('SYSPATH') OR die('No direct script access.');

class Request extends Kohana_Request {
	public static function is_social_network()
	{
		$user_agent = strtolower(Request::$user_agent);
        $social_agents = array('facebookexternalhit', 'Googlebot', 'Twitterbot', 'Pinterest');
        $is_social_network = false;
        foreach ($social_agents as $social_agent)
        {
            if (strstr($user_agent, $social_agent) != false)
            {
                $is_social_network = true;
            }
        }
		
		return $is_social_network;
	}
	
	public static function is_bot()
	{
		$bots = Infolist::bots();
		
	    foreach($bots as $bot)
		{
			if (strpos(Request::$user_agent, $bot) !== false)
			{
				return true;
			}
	    }
		
	    return false;
	}
}
	