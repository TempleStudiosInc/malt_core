<?php
    class Format {
        public static function create_sort_link($title, $field, $query_array, $controller)
        {
            $sort_title = $title;
            $sort_field_name = $field;
            $temp_query_array = $query_array;
            $temp_query_array['order_by'] = $sort_field_name;
            
            if ( ! in_array($sort_field_name, $query_array))
            {
                $temp_query_array['sorted'] = 'asc';
            }
            else
            {
                if ($query_array['sorted'] == 'desc')
                {
                    $sort_title.= '&darr;';
                    $temp_query_array['sorted'] = 'asc';
                }
                else
                {
                    $sort_title.= '&uarr;';
                    $temp_query_array['sorted'] = 'desc';
                }
            }
            return HTML::anchor('/'.$controller.'?'.http_build_query($temp_query_array), $sort_title);
        }
		
		public static function file_size($size)
		{
			$mod = 1024;
			$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
			for ($i = 0; $size > $mod; $i++)
			{
				$size /= $mod;
			}
			return round($size, 2) . ' ' . $units[$i];
		}
		
		public static function url_title($title)
		{
			$title = strtolower($title);
			$title = str_replace(array(' '), '_', $title);
			$title = str_replace(array("'", '"', '%', '$', '#', '@', '*', '&', '^', ',', ':', ';', '!', '?'), '', $title);
			
			return $title;
		}
		
		public static function database_datetime($date = null)
		{
			if ( ! $date)
			{
				$date = 'now';
			}
			return date('Y-m-d H:i:s', strtotime($date));
		}
		
		public static function standard_datetime($date = null)
		{
			if ( ! $date)
			{
				$date = 'now';
			}
			return date('m/d/Y g:iA', strtotime($date));
		}
		
		public static function readable_datetime($date = null)
		{
			if ( ! $date)
			{
				$date = 'now';
			}
			return date('F jS, Y g:iA', strtotime($date));
		}
		
		public static function relative_date($date = null)
		{
			if ( ! $date)
			{
				$date = 'now';
			}
			
			if (!ctype_digit($date))
			{
				$date = strtotime($date);
			}
			
			$diff = time() - $date;
			if ($diff == 0)
			{
				return 'now';
			}
			elseif ($diff > 0)
			{
				$day_diff = floor($diff / 86400);
				if ($day_diff == 0)
				{
					if ($diff < 60)
					{
						return 'just now';
					}
					if ($diff < 120)
					{
						return '1 minute ago';
					}
					if ($diff < 3600)
					{
						return floor($diff / 60) . ' minutes ago';
					}
					if ($diff < 7200)
					{
						return '1 hour ago';
					}
					if ($diff < 86400)
					{
						return floor($diff / 3600) . ' hours ago';
					}
				}
				if ($day_diff == 1)
				{
					return 'Yesterday';
				}
				if ($day_diff < 7)
				{
					return $day_diff . ' days ago';
				}
				if ($day_diff < 31)
				{
					return ceil($day_diff / 7) . ' weeks ago';
				}
				if ($day_diff < 60)
				{
					return 'last month';
				}
				return date('F Y', $date);
			}
			else
			{
				$diff = abs($diff);
				$day_diff = floor($diff / 86400);
				if ($day_diff == 0)
				{
					if ($diff < 120)
					{
						return 'in a minute';
					}
					if ($diff < 3600)
					{
						return 'in ' . floor($diff / 60) . ' minutes';
					}
					if ($diff < 7200)
					{
						return 'in an hour';
					}
					if ($diff < 86400)
					{
						return 'in ' . floor($diff / 3600) . ' hours';
					}
				}
				if ($day_diff == 1)
				{
					return 'Tomorrow';
				}
				if ($day_diff < 4)
				{
					return date('l', $date);
				}
				if ($day_diff < 7 + (7 - date('w')))
				{
					return 'next week';
				}
				if (ceil($day_diff / 7) < 4)
				{
					return 'in ' . ceil($day_diff / 7) . ' weeks';
				}
				if (date('n', $date) == date('n') + 1)
				{
					return 'next month';
				}
				return date('F Y', $date);
			}
		}

		public static function page_title($site_name = false)
		{
			$request = Request::initial();
	        $requested_controller = $request->controller();
	        $requested_action = $request->action();
			$requested_uri = $request->uri();
			
			$title = '';
            $application = str_replace('application/', '', APPLICATION);
	        $page_main_title = ucwords(str_replace('_', ' ', str_replace(ucfirst($application).'_', '', $requested_controller)));
	        if ($requested_action != 'index')
	        {
	            $page_main_title .= ' - '.ucwords(str_replace('_', ' ', $requested_action));
	        }
	        $page_main_title = str_replace('Index', 'Home', $page_main_title);
	        
			if ($site_name AND $site_name != '')
			{
				$title = $site_name.' - ';
			}
			
	        if (! isset($page_title) OR $page_title == '')
	        {
	            $title.= $page_main_title;
	        }
	        else
	        {
	            $title = $this->site_name.' - '.$this->page_title;
	        }
			
			return $title;
		}

		public static function generate_unique_id()
	    {
	        return strtoupper(uniqid());
	    }
		
		public static function currency($price)
		{
			$formatted_price = '';
			if ($price < 0)
			{
				$formatted_price.= '-';
			}
			$formatted_price.= '$';
			$formatted_price.= number_format(abs($price), 2);
			return $formatted_price;
		}
		
		public static function percentage($number)
		{
			$formatted_number = '';
			if ($number < 0)
			{
				$formatted_number.= '-';
			}
			$formatted_number.= number_format(abs($number*100), 0);
			$formatted_number.= '%';
			return $formatted_number;
		}
		
		public static function price_difference($price_1, $price_2)
		{
			$formatted_price = '';
			if ($price_1 > $price_2)
			{
				$formatted_price.= '+';
			}
			else
			{
				$formatted_price.= '-';
			}
			$formatted_price.= '$';
			$formatted_price.= number_format(abs($price_1 - $price_2), 2);
			return $formatted_price;
		}
		
		public static function credit_card_name($name)
		{
			switch($name)
			{
				case 'amex':
					return 'American Express';
				case 'visa':
					return 'Visa';
				case 'discover':
					return 'Discover';
				case 'mastercard':
					return 'MasterCard';
                case 'paypal':
                    return 'PayPal';
			}
		}
		
		public static function short_credit_card_name($name)
		{
			switch($name)
			{
				case 'American Express':
					return 'amex';
				case 'Visa':
					return 'visa';
				case 'Discover':
					return 'discover';
				case 'MasterCard':
					return 'mastercard';
                case 'PayPal':
                    return 'paypal';
			}
		}
		
		public static function youtube_iframe($html)
		{
			$document = new DOMDocument();
			$document->loadHTML($html);
			$lst = $document->getElementsByTagName('iframe');
    		for ($i=0; $i<$lst->length; $i++)
    		{
				$iframe = $lst->item($i);
				$iframce_source = $iframe->attributes->getNamedItem('src')->value;
				$html = str_replace($iframce_source, $iframce_source.'?enablejsapi=1', $html);
			}
			
			return $html;
		}
    }