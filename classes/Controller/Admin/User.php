<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Admin_Website {

	public function before()
	{
		parent::before();
		
		$model_name = 'user';
		$plural_model_name = Inflector::plural($model_name);
		$this->template->content_title = 'Users';
		$this->page_title.= ' - '.Text::ucfirst($model_name);
		$this->content_title = Text::ucfirst($plural_model_name);
		$this->model_name = $model_name;
		$this->plural_model_name = $plural_model_name;
		
		$roles = ORM::factory('Role')->where('name', '!=', 'login')->find_all();
		$this->roles = $roles;
	}
	
	public function after()
    {
    	$request = Request::initial();
		$requested_controller = str_replace('Admin_', '', $request->controller());
		$requested_action = $request->action();
		
        parent::after();
    }
	
	public function action_index()
	{
		$breadcrumb = View::factory('user/admin/breadcrumb');
		$breadcrumb_items = array();
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		
	    $roles = ORM::factory('Role')->where('name', '=', 'admin')->find_all();
        $this->roles = $roles;
        
		$model_name = $this->model_name;
		
		$view = View::factory($model_name.'/admin/index');
		$view->model_name = $this->model_name;
		$view->content_title = $this->content_title;
        
        $request = Request::initial();
        $query_array = $request->query();
        $view->query_array = $query_array;
		
		$search_form = array(
			'username' => '',
			'email' => '',
			'first_name' => '',
			'last_name' => ''
		);
		$form = Arr::get($_GET, 'form', $search_form);
		if ( ! isset($form))
		{
			$form = array();
		}
		foreach ($search_form as $key => $value)
		{
			$form[$key] = Arr::get($form, $key, $value);
		}
		$view->form = $form;
				
		$users = $this->database_search($model_name, $form);
		$result_count = $users->count_all();
		
		$users = $this->database_search($model_name, $form);
        
        $page = Arr::get($_GET, 'page', 1);
        
        if (Arr::get($_GET, 'view_all', false))
        {
            $page_limit = $result_count;
            
            $view_all_button = HTML::anchor('/admin_user', 'Paginate List', array('id' => 'abutton', 'class' => 'btn btn-success'));
            $view->view_all_button = $view_all_button;
        }
        else
        {
            $page_limit = 20;
            $offset = ($page-1)*$page_limit;
            $users->limit($page_limit)->offset($offset);
            
            $view_all_button = HTML::anchor('/admin_user?view_all=true', 'View All', array('id' => 'abutton', 'class' => 'btn btn-success'));
            $view->view_all_button = $view_all_button;
        }
        
        $pagination = Pagination::factory(array(
            'items_per_page' => $page_limit,
            'total_items' => $result_count,
        ));
        $view->pagination = $pagination;
        
        $order_by_value = Arr::get($_GET, 'order_by', 'id');
        $sorted = Arr::get($_GET, 'sorted', 'asc');
		
		if($order_by_value == 'admin')
		{
			$users = ORM::factory('user')->join('roles_users','left')->on('roles_users.role_id','=','user.id')->group_by('user.id')->distinct('user.id')->order_by('roles_users.role_id','desc')->find_all();
		}
		else 
		{
			$users = $users->order_by($order_by_value,$sorted)->find_all();
		}
		$view->users = $users;
		$view->roles = $this->roles;
		
		$this->template->body = $view;
	}
	
	public function action_add()
	{
		$breadcrumb = View::factory('user/admin/breadcrumb');
		$breadcrumb_items = array(
			'/admin_user/add' => 'Add User',
		);
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		
		$action = 'add';
		$model_name = $this->model_name;
		
		$view = View::factory($model_name.'/admin/add_edit');
		$view->model_name = $this->model_name;
		$view->action = $action;
		$view->content_title = $this->content_title.' - '.Text::ucfirst($action).' '.Text::ucfirst($model_name);
		
		$session = Session::instance();
		$user_form = $session->get('user_form');
		
		$user = ORM::factory($model_name);
		$view->add_edit_user = $user;
		
		if (is_array($user_form) AND Arr::get($user_form, 'user'))
		{
			foreach (Arr::get($user_form, 'user') as $key => $item)
			{
				try
				{
					$user->$key = $item;
				}
				catch(Exception $exception)
				{
					
				}
			}
		}
		
		$view->user_form = $user_form;
		
		$view->roles = $this->roles;
		
		$this->template->body = $view;
	}
	
	public function action_edit()
	{
		$user_id = $this->request->param('id');
		
		$breadcrumb = View::factory('user/admin/breadcrumb');
		$breadcrumb_items = array(
			'/admin_user/edit/'.$user_id => 'Edit User',
		);
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		
		$this->template->content_header_navigation = HTML::anchor('/admin_user/view/'.$user_id, 'View User', array('class' => 'btn btn-small'));;
		
		$action = 'edit';
		$model_name = $this->model_name;
		
		$view = View::factory($model_name.'/admin/add_edit');
		$view->model_name = $this->model_name;
		$view->action = $action;
		$view->content_title = $this->content_title.' - '.Text::ucfirst($action).' '.Text::ucfirst($model_name);
		
		$user = ORM::factory('User', $user_id);
		$view->add_edit_user = $user;
		
		$view->roles = $this->roles;
		
		$this->template->body = $view;
	}
	
	public function action_view()
	{
		$user_id = $this->request->param('id');
		
		$breadcrumb = View::factory('user/admin/breadcrumb');
		$breadcrumb_items = array(
			'/admin_user/view/'.$user_id => 'View User',
		);
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		
		$this->template->content_header_navigation = HTML::anchor('/admin_user/edit/'.$user_id, 'Edit User', array('class' => 'btn btn-small'));;
		
		$action = 'edit';
		$model_name = $this->model_name;
		
		$view = View::factory($model_name.'/admin/view');
		$view->model_name = $this->model_name;
		$view->action = $action;
		$view->content_title = $this->content_title.' - '.Text::ucfirst($action).' '.Text::ucfirst($model_name);
		
		$user = ORM::factory('User', $user_id);
		$view->add_edit_user = $user;
		
		$view->roles = $this->roles;
		
		$this->template->body = $view;
	}
	
	public function action_myaccount()
	{
		$breadcrumb = View::factory('user/admin/breadcrumb');
		$breadcrumb_items = array(
			'/admin_user/myaccount' => 'My Account',
		);
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		$action = 'edit';
		$model_name = $this->model_name;
		
		$view = View::factory($model_name.'/admin/add_edit');
		$view->model_name = $this->model_name;
		$view->action = $action;
		$view->content_title = $this->content_title.' - '.Text::ucfirst($action).' '.Text::ucfirst($model_name);
		
		$user_id = $this->user->id;
		
		$user = ORM::factory('User', $user_id);
		$view->user = $user;
		
		$view->roles = $this->roles;
		
		$locations_orm = ORM::factory('location')->where('status', '=', 'active')->find_all();
		$locations = array();
		foreach ($locations_orm as $location)
		{
			$locations[$location->id] = $location->name;
		}
		$view->locations = $locations;
		
		$this->template->body = $view;
	}
	
	public function action_save()
	{
		$model_name = $this->model_name;
		
		$user_id = $this->request->param('id');
		if ($user_id)
		{
			$user = ORM::factory($model_name, $user_id);
		}
		else
		{
			$user = ORM::factory($model_name);
		}
		
		$post = Arr::get($_POST, 'form', null);
		
		$user->username = $post['user']['username'];
		$user->email = $post['user']['email'];
		$user->first_name = $post['user']['first_name'];
		$user->last_name = $post['user']['last_name'];
		$user->phone_number = $post['user']['phone_number'];
		
		if (isset($post['user']['password']) AND $post['user']['password'] != '')
		{
			$user->password = $post['user']['password'];
		}
		try
		{
			$user->save();
		}
		catch(Exception $exception)
		{
			$errors = $exception->errors();
			
			$message = 'Please correct the following errors.';
			$message.= '<ul>';
			foreach ($errors as $key => $error)
			{
				switch ($key)
				{
					case 'username':
						switch (Arr::get($error, 0))
						{
							case 'not_empty':
								$message.= '<li>Username must be set.</li>';
								break;
							case 'unique':
								$message.= '<li>Username ('.Arr::get(Arr::get($error, 1), 1).') is already taken.</li>';
								break;
						}
						break;
					case 'password':
						switch (Arr::get($error, 0))
						{
							case 'not_empty':
								$message.= '<li>Password must be set.</li>';
								break;
						}
						break;
					case 'email':
						switch (Arr::get($error, 0))
						{
							case 'not_empty':
								$message.= '<li>Email address must be set.</li>';
								break;
							case 'unique':
								$message.= '<li>Email address ('.Arr::get(Arr::get($error, 1), 1).') is already used.</li>';
								break;
							case 'email':
								$message.= '<li>Please enter a valid email address.</li>';
								break;
						}
						break;
				}
			}
			$message.= '</ul>';
			
			$session = Session::instance();
			$session->set('user_form', $post);
			
			Notice::add(Notice::ERROR, $message);
			$this->redirect('/admin_user/add');
			die();
		}
		
		if ( ! $user->has('roles', 1))
		{
			$user->add('roles', ORM::factory('role', array('name' => 'login')));
		}
		
		foreach ($this->roles as $role)
		{
			$user_name = $role->name;
			
			if (isset($post['role'][$role->id]))
			{
				if ( ! $user->has('roles', $role->id))
				{
					$user->add('roles', $role->id);
				}
			}
			else
			{
				$user->remove('roles', $role->id);
			}
		}
		
		$message = Text::ucfirst($model_name).' Saved.';
		Notice::add(Notice::SUCCESS, $message);
		$this->redirect('/admin_'.$model_name);
	}

	public function action_delete()
	{
		$user_id = $this->request->param('id');
		
		if ($user_id)
		{
			$user = ORM::factory('user', $user_id);
			$user->delete();
			Notice::add(Notice::SUCCESS, 'User Deleted.');
			$this->redirect('/admin_user');
		}
		else
		{
			Notice::add(Notice::ERROR, 'User not found.');
			$this->redirect('/admin_user');
		}
	}
	
	private function database_search($model, $params)
	{
		$model_orm = ORM::factory($model);
		foreach ($params as $key => $value)
		{
			if ($value != '')
			{
				$model_orm->where($key, 'like', '%'.$value.'%');
			}
		}
		return $model_orm;
	}
    
    public function action_cleanup()
    {
        // campaigns_users
        $query = DB::select('users.id')
            ->select(array('campaigns_users.id', 'campaigns_users_id'))
            ->from('campaigns_users')
            ->join('users', 'LEFT')
            ->on('campaigns_users.user_id', '=', 'users.id')
            ->where('users.id', 'IS', DB::expr('NULL'));
        $results = $query->execute();
        
        foreach ($results as $result)
        {
            ORM::factory('campaigns_user', $result['campaigns_users_id'])->delete();
            echo '<pre>Deleting Campaign User '.$result['campaigns_users_id'].'</pre>';
        }
        
        // prayers_users
        $query = DB::select('users.id')
            ->select(array('prayers_users.id', 'prayers_users_id'))
            ->from('prayers_users')
            ->join('users', 'LEFT')
            ->on('prayers_users.user_id', '=', 'users.id')
            ->where('users.id', 'IS', DB::expr('NULL'));
        $results = $query->execute();
        
        foreach ($results as $result)
        {
            ORM::factory('prayers_user', $result['prayers_users_id'])->delete();
            echo '<pre>Deleting Prayer User '.$result['prayers_users_id'].'</pre>';
        }
        
        // friends_users
        $query = DB::select('users.id')
            ->select(array('friends_users.id', 'friends_users_id'))
            ->from('friends_users')
            ->join('users', 'LEFT')
            ->on('friends_users.user_id', '=', 'users.id')
            ->where('users.id', 'IS', DB::expr('NULL'));
        $results = $query->execute();
        
        foreach ($results as $result)
        {
            ORM::factory('friends_user', $result['friends_users_id'])->delete();
            echo '<pre>Deleting Friends User '.$result['friends_users_id'].'</pre>';
        }
        
        // addresses
        $query = DB::select('users.id')
            ->select(array('addresses.id', 'addresses_id'))
            ->from('addresses')
            ->join('users', 'LEFT')
            ->on('addresses.user_id', '=', 'users.id')
            ->where('users.id', 'IS', DB::expr('NULL'));
        $results = $query->execute();
        
        foreach ($results as $result)
        {
            ORM::factory('address', $result['addresses_id'])->delete();
            echo '<pre>Deleting Address '.$result['addresses_id'].'</pre>';
        }
        
        // oauthusers
        $query = DB::select('users.id')
            ->select(array('oauthusers.id', 'oauthusers_id'))
            ->from('oauthusers')
            ->join('users', 'LEFT')
            ->on('oauthusers.user_id', '=', 'users.id')
            ->where('users.id', 'IS', DB::expr('NULL'));
        $results = $query->execute();
        
        foreach ($results as $result)
        {
            ORM::factory('oauthuser', $result['oauthusers_id'])->delete();
            echo '<pre>Deleting Oauthuser '.$result['oauthusers_id'].'</pre>';
        }
        die();
    }
    
    public function action_delete_credit_card()
    {
        $payment_driver = Kohana::$config->load('payment.default.driver');
        
        $config = Kohana::$config->load('payment.drivers.'.$payment_driver);
        $test_mode = Arr::get($config, 'test_mode', true);
        $merchant_id = Arr::get($config, 'merchant_id');
        $public_key = Arr::get($config, 'public_key');
        $private_key = Arr::get($config, 'private_key');
        
        Braintree_Configuration::environment($test_mode?'sandbox':'live');
        Braintree_Configuration::merchantId($merchant_id);
        Braintree_Configuration::publicKey($public_key);
        Braintree_Configuration::privateKey($private_key);
        
        $credit_card_id = $this->request->param('id');
        
        $credit_card = ORM::factory('Users_Creditcard', $credit_card_id);
        if ($credit_card->loaded())
        {
            $result = Braintree_CreditCard::delete($credit_card->credit_card_id);
            
            if ($result->success)
            {
                $credit_card->status = 'removed';
                $credit_card->save();
                
                Notice::add(NOTICE::SUCCESS, 'Credit card removed.');
            }
            else
            {
                Notice::add(Notice::ERROR, $result->message);
            }
            $this->redirect('/admin_user/view/'.$credit_card->user_id);
        }
        
        Notice::add(Notice::ERROR, 'Credit card not found.');
        $this->redirect('/admin_user/view/');
    }
}