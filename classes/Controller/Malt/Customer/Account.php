<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Malt_Customer_Account extends Controller_Customer_Website {
	
	public function before()
	{
		$this->secure = true;
		$this->auth = Auth::instance();
        $logged_in = $this->auth->logged_in();
		
		if ( ! $logged_in)
		{
			$session = Session::instance();
			$session->set('referrer_url', $this->request->detect_uri());
			Notice::add(Notice::INFO, 'Please login.');
			$this->redirect('login');
		}
		parent::before();
	}
	
	public function action_index()
	{
		$view = View::factory('account/customer/template');
		
		$page = View::factory('account/customer/index');
		$page->user = $this->user;
		$view->page = $page;
		
		$this->template->body = $view;
	}
	
	public function action_save()
	{
		$account = Arr::get($_POST, 'account', false);
		
		if ($account)
		{
			$this->user->username = Arr::get($account, 'username');
			$this->user->email = Arr::get($account, 'email');
			$this->user->first_name = Arr::get($account, 'first_name');
			$this->user->last_name = Arr::get($account, 'last_name');
			$this->user->save();
			
			Notice::add(Notice::SUCCESS, 'Account Saved.');
		}
		else
		{
			Notice::add(Notice::ERROR, 'Account not Saved.');
		}
		$this->redirect('account');
	}
	
	public function action_password()
	{
		$view = View::factory('account/customer/template');
		
		$page = View::factory('account/customer/password');
		$page->user = $this->user;
		$view->page = $page;
		
		$this->template->body = $view;
	}
	
	public function action_save_password()
	{
		$account = Arr::get($_POST, 'account', false);
		
		if ($account)
		{
			$this->user->password = Arr::get($account, 'new_password');
			$this->user->save();
			
			Notice::add(Notice::SUCCESS, 'Password Saved.');
		}
		else
		{
			Notice::add(Notice::ERROR, 'Password not Saved.');
		}
		$this->redirect('account/password');
	}
	
	public function action_address()
	{
		$view = View::factory('account/customer/template');
		
		$page = View::factory('account/customer/address');
		$page->billing_address = $this->user->addresses->where('type', '=', 'billing')->find();
		$page->shipping_address = $this->user->addresses->where('type', '=', 'shipping')->find();
		
		$regions = ORM::factory('Region')->find_all();
		$regions_select = array();
		foreach ($regions as $region)
		{
			$regions_select[$region->id] = $region->country;
		}
		
		$us_key = array_search('United States', $regions_select);
		$us_temp = array($us_key => $regions_select[$us_key]);
    	unset($regions_select[$us_key]);
    	$regions_select = $us_temp+$regions_select;
		$page->regions = $regions_select;
		
		$view->page = $page;
		
		$this->template->body = $view;
	}
	
	public function action_save_address()
	{
		$address = Arr::get($_POST, 'address', array());
		$billing_address = Arr::get($address, 'billing', array());
		$shipping_address = Arr::get($address, 'shipping', array());
		
		$changed = false;
		$user_billing_address = $this->user->addresses->where('type', '=', 'billing')->find();
		$user_billing_address->user_id = $this->user->id;
		$user_billing_address->type = 'billing';
		$user_billing_address->address_1 = Arr::get($billing_address, 'address');
		$user_billing_address->address_2 = Arr::get($billing_address, 'address_2');
		$user_billing_address->city = Arr::get($billing_address, 'city');
		$user_billing_address->state = Arr::get($billing_address, 'state');
		$user_billing_address->zip = Arr::get($billing_address, 'zip');
		$user_billing_address->country = Arr::get($billing_address, 'country');
		if ($user_billing_address->changed())
		{
			$changed = true;
			$user_billing_address->save();
		}
		
		$user_shipping_address = $this->user->addresses->where('type', '=', 'shipping')->find();
		$user_shipping_address->user_id = $this->user->id;
		$user_shipping_address->type = 'shipping';
		$user_shipping_address->address_1 = Arr::get($shipping_address, 'address');
		$user_shipping_address->address_2 = Arr::get($shipping_address, 'address_2');
		$user_shipping_address->city = Arr::get($shipping_address, 'city');
		$user_shipping_address->state = Arr::get($shipping_address, 'state');
		$user_shipping_address->zip = Arr::get($shipping_address, 'zip');
		$user_shipping_address->country = Arr::get($shipping_address, 'country');
		if ($user_shipping_address->changed())
		{
			$changed = true;
			$user_shipping_address->save();
		}
		
		if ($changed)
		{
			Notice::add(Notice::SUCCESS, 'Addresses Saved.');
		}
		else
		{
			Notice::add(Notice::INFO, 'No changes were made.');
		}
		$this->redirect('account/address');
	}
	
	public function action_check_email()
    {
    	$username = $_GET['account']['email'];
		if ($username  == $this->user->email)
		{
			echo 'true';
		}
		else
		{
			$user = ORM::factory('User')->where('email', '=', $email)->find();
	        if ( ! $user->loaded())
	        {
	            echo 'true';
	        }
	        else
	        {
	            echo 'false';
	        }
		}
        die();
    }
    
    public function action_check_username()
    {
        $username = $_GET['account']['username'];
		if ($username  == $this->user->username)
		{
			echo 'true';
		}
		else
		{
			$user = ORM::factory('User')->where('username', '=', $username)->find();
	        if ( ! $user->loaded())
	        {
	            echo 'true';
	        }
	        else
	        {
	            echo 'false';
	        }
		}
        die();
    }
	
	public function action_check_password()
    {
        $password = $_GET['account']['password'];
		if ($this->auth->hash_password($password) == $this->user->password)
		{
			echo 'true';
		}
		else
		{
			echo 'false';
		}
        die();
    }
}