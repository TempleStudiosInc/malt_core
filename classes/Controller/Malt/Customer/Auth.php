<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Malt_Customer_Auth extends Controller_Customer_Website {
    
	public function before()
	{
		$this->secure = true;
		parent::before();
	}
	
    public function action_login()
    {
        $request = Request::initial();
        
        $session = Session::instance();
        
        $auth = Auth::instance();
        if ($session->get('referrer_url', false) === false)
        {
            $referrer_url = $request->referrer();
            if ($referrer_url == NULL)
            {
                $referrer_url = '/';
            }
            $session->set('referrer_url', $referrer_url);
        }
        
        if (isset($this->user) AND $auth->logged_in())
        {
            $this->redirect($session->get('referrer_url'));
        }
        
        $view = View::factory('auth/login');
        
        $this->template->body = $view;
    }
    
    public function action_login_facebook()
    {
        require_once Kohana::find_file('vendor', 'facebook/facebook');
        
        $session = Session::instance();
        
        $facebook_config = (array) Kohana::$config->load('facebook');
        $facebook = new Facebook($facebook_config);
        
        $facebook_login_state = Arr::get($_GET, 'state', false);
        
        if ($facebook_login_state)
        {
            $facebook_user = $facebook->getUser();
            if (isset($facebook_user) AND $facebook_user > 0)
            {
                $facebook_profile = (object) $facebook->api('/me');
                
                $oauthuser = ORM::factory('Oauthuser')->where('oauth_type', '=', 'facebook')->where('oauth_user_id', '=', $facebook_user)->find();
                
                if ($oauthuser->id == 0)
                {
                    // Oauth User Not Found - Register or Link
                    $facebook_profile = (object) $facebook->api('/me');
                   
                    $user = ORM::factory('User')->where('email', '=', $facebook_profile->email)->find();
                    if ($user->loaded() AND $user->id > 0)
                    {
                        // User with Facebook Email found - link to user
                        $oauthuser = ORM::factory('Oauthuser');
                        $oauthuser->user_id = $user->id;
                        $oauthuser->oauth_type = 'facebook';
                        $oauthuser->oauth_user_id = $facebook_user;
                        $oauthuser->token = $facebook->getAccessToken();
                        $oauthuser->save();
                    }
                    else
                    {
                        // User with Facebook Email not found - Register user
                        $facebook_profile = (object) $facebook->api('/me');
                        
                        $user = ORM::factory('User');
                        $user->username = $facebook_profile->email;
                        $user->email = $facebook_profile->email;
                        $user->first_name = $facebook_profile->first_name;
                        $user->last_name = $facebook_profile->last_name;
                        $user->password = 'test1234';
                        $user->save();
                        
                        $oauthuser = ORM::factory('Oauthuser');
                        $oauthuser->user_id = $user->id;
                        $oauthuser->oauth_type = 'facebook';
                        $oauthuser->oauth_user_id = $facebook_user;
                        $oauthuser->token = $facebook->getAccessToken();
                        $oauthuser->save();
                    }
                }
                
                // Oauth User Found - Login
                $this->auth->force_login($oauthuser->user);
                $redirect_url = $session->get('referrer_url', '/');
                $session->delete('referrer_url');
                $message = "You have been logged in. Welcome ".$oauthuser->user->username.'.';
                Notice::add(Notice::SUCCESS, $message);
                Notice::set_logins();
                $this->redirect($redirect_url);
            }
            die();
        }
        else
        {
            $login_url = $facebook->getLoginUrl(array(
                'scope' => $facebook_config['req_perms']
            ));
            $this->redirect($login_url);
        }
    }
    
    public function action_login_twitter()
    {
        require_once Kohana::find_file('vendor', 'twitter/twitteroauth');
        
        $session = Session::instance();
        
        define('CONSUMER_KEY', Kohana::$config->load('twitter.consumer_key'));
        define('CONSUMER_SECRET', Kohana::$config->load('twitter.consumer_secret'));
        define('OAUTH_CALLBACK', 'http://'.$_SERVER["SERVER_NAME"].URL::site('/auth/login_twitter'));
        
        $access_token = $session->get('access_token', false);
        $oauth_verifier = Arr::get($_REQUEST, 'oauth_verifier');
        
        if ($access_token AND $oauth_verifier)
        {
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
            // $content = $connection->get('account/verify_credentials');
            // echo Debug::vars($content);
            
            $access_token = $connection->getAccessToken($oauth_verifier);
            
            if (isset($access_token['user_id']) AND $access_token['user_id'] != 0)
            {
                $oauthuser = ORM::factory('Oauthuser')->where('oauth_type', '=', 'twitter')->where('oauth_user_id', '=', $access_token['user_id'])->find();
                
                if ($oauthuser->id == 0)
                {
                    // Oauth User Not Found - Register or Link
                    $user = ORM::factory('User')->where('username', '=', $access_token['screen_name'])->find();
                    if ($user->loaded() AND $user->id > 0)
                    {
                        // User with Facebook Email found - link to user
                        $oauthuser = ORM::factory('Oauthuser');
                        $oauthuser->user_id = $user->id;
                        $oauthuser->oauth_type = 'twitter';
                        $oauthuser->oauth_user_id = $access_token['user_id'];
                        $oauthuser->token = $access_token['oauth_token'];
                        $oauthuser->save();
                    }
                    else
                    {
                        // User with Twitter Email not found - Register user
                        $user = ORM::factory('User');
                        $user->username = $access_token['screen_name'].'@timeofgrace.com';
                        $user->email = $access_token['screen_name'].'@timeofgrace.com';
                        $user->password = 'test1234';
                        $user->save();
                        
                        $oauthuser = ORM::factory('Oauthuser');
                        $oauthuser->user_id = $user->id;
                        $oauthuser->oauth_type = 'twitter';
                        $oauthuser->oauth_user_id = $access_token['user_id'];
                        $oauthuser->token = $access_token['oauth_token'];
                        $oauthuser->save();
                    }
                }
                
                // Oauth User Found - Login
                
                $this->auth->force_login($oauthuser->user);
                $redirect_url = $session->get('referrer_url', '/');
                $session->delete('referrer_url');
                $message = "You have been logged in. Welcome ".$oauthuser->user->username.'.';
                Notice::add(Notice::SUCCESS, $message);
                Notice::set_logins();
                $this->redirect($redirect_url);
                die();
            }
        }
        else
        {
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
            
            $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
            $token = $request_token['oauth_token'];
            $session->set('access_token', $request_token);
            $session->set('oauth_token', $token);
            $session->set('oauth_token_secret', $request_token['oauth_token_secret']);
            
            $url = $connection->getAuthorizeURL($token);
            $this->redirect($url);
        }
        die();
    }
    
    public function action_login_google()
    {
        require_once Kohana::find_file('vendor', 'google/apiClient');
        require_once Kohana::find_file('vendor', 'google/contrib/apiOauth2Service');
        
        $session = Session::instance();
        
        $code = Arr::get($_GET, 'code', false);
        
        $google_config = (array) Kohana::$config->load('google');
        
        $client = new apiClient($google_config);
        $oauth2 = new apiOauth2Service($client);
        
        
        if ($code)
        {
            $client->authenticate();
            $session->set('token', $client->getAccessToken());
            $this->redirect('/auth/login_google');
        }
        
        if ($session->get('token', false)) {
            $client->setAccessToken($session->get('token'));
        }
        
        if ($client->getAccessToken())
        {
            $session->set('token', $client->getAccessToken());
            
            $google_user = $oauth2->userinfo->get();
            
            $oauthuser = ORM::factory('Oauthuser')->where('oauth_type', '=', 'google')->where('oauth_user_id', '=', $google_user->id)->find();
            
            if ($oauthuser->id == 0)
            {
                // Oauth User Not Found - Register or Link
                $user = ORM::factory('User')->where('email', '=', $google_user->email)->find();
                if ($user->loaded() AND $user->id > 0)
                {
                    // User with Facebook Email found - link to user
                    $oauthuser = ORM::factory('Oauthuser');
                    $oauthuser->user_id = $user->id;
                    $oauthuser->oauth_type = 'google';
                    $oauthuser->oauth_user_id = $google_user->id;
                    $oauthuser->token = $session->get('token');
                    $oauthuser->save();
                }
                else
                {
                    // User with Facebook Email not found - Register user
                    $user = ORM::factory('User');
                    $user_email = explode('@', $google_user->email);
                    $user->username = $google_user->email;
                    $user->email = $google_user->email;
                    $user_name = explode(' ', $google_user->name);
                    $user->first_name = $user_name[0];
                    $user->last_name = $user_name[1];
                    $user->password = 'test1234';
                    $user->save();
                    
                    $oauthuser = ORM::factory('Oauthuser');
                    $oauthuser->user_id = $user->id;
                    $oauthuser->oauth_type = 'google';
                    $oauthuser->oauth_user_id = $google_user->id;
                    $oauthuser->token = $session->get('token');
                    $oauthuser->save();
                }
            }
            
			
            // Oauth User Found - Login
            $this->auth->force_login($oauthuser->user);
            $redirect_url = $session->get('referrer_url', '/');
            $session->delete('referrer_url');
            $message = "You have been logged in. Welcome ".$oauthuser->user->username.'.';
            Notice::add(Notice::SUCCESS, $message);
            Notice::set_logins();
            $this->redirect($redirect_url);
        }
        else
        {
            $auth_url = $client->createAuthUrl();
            $this->redirect($auth_url);
        }
        die();
    }
    
    public function action_register()
    {
        $view = View::factory('auth/login');
        
        $this->template->body = $view;
    }
    
    public function action_process_login()
    {
        $this->auth = Auth::instance();
        
        $post = Arr::get($_POST, 'login', null);
        
        $remember = false;
        if (isset($post['remember']))
        {
            $remember = true;
        }
		
        $login_result = $this->auth->login($post['username'], trim($post['password']), $remember);
		$user = $this->auth->get_user();
		
        if ($login_result == true)
        {
            $user = $this->auth->get_user();
			$orm_user = ORM::factory('User', $user->id);
			
            if ($orm_user->logins == '2')
			{
				$content = ORM::factory('Content')->where('node_name','=', 'greetings_loginmessage')->find();
				if ($content->loaded())
				{
					$message = $content->get_field_value('message');
					if ($message != '')
					{
						Notice::add(Notice::LOGIN, $message);
					}
					else
					{
						$message = "You have been logged in. Welcome ".$user->username.'.';
	                	Notice::add(Notice::SUCCESS, $message);
					}
				}
				else 
				{
					$message = "You have been logged in. Welcome ".$user->username.'.';
	            	Notice::add(Notice::SUCCESS, $message);
				}
			}
			else 
			{
				$message = "You have been logged in. Welcome ".$user->username.'.';
            	Notice::add(Notice::SUCCESS, $message);
			}
			
			Notice::set_logins();
            $session = Session::instance();
            $redirect_url = $session->get('referrer_url', '/account');
            $session->delete('referrer_url');
            $this->redirect($redirect_url);
        }
        elseif ($user AND ! $user->has('roles', ORM::factory('Role', 1)))
        {
        	$user = ORM::factory('User')->where('username', '=', $post['username'])->or_where('email', '=', $post['username'])->find();
            Notice::add(Notice::ERROR, 'Please check your email ('.$user->email.') to activate your account.');
            $this->redirect('login');
        }
        else
        {
            Notice::add(Notice::ERROR, 'The username or password you entered is incorrect.');
            $this->redirect('login');
        }
    }
    
    public function action_logout()
    {
        Notice::add(Notice::INFO, 'You have been logged out.');
        Auth::instance()->logout();
        $this->redirect('login');
    }
    
    public function action_process_register()
    {
		$post = Arr::get($_POST,'register');
		if ($post)
		{
			try {
			$user = ORM::factory('User')->create_user($post, array('username', 'email', 'password'));
			$Login_role = ORM::factory('Role')->where('name', '=', 'login')->find();
			$user->add('roles', $Login_role);
			
			$this->auth->force_login($user);
			
			$message = 'Thank you for registering.';
        	Notice::add(Notice::SUCCESS, $message);
			$this->redirect('/account');
		}
			catch (Exception $e)
			{
				$errors = $e->getMessage();
				Notice::add(Notice::ERROR, 'Please correct the following.', null, array($errors));
				$this->redirect('/login');
			}
		}
    }
    
    public function action_profile()
    {
        $view = View::factory('auth/profile');
        if (isset($this->user))
        {
            $view->user = $this->user;
        }
        else
        {
            $message = 'Please log in.';
            Notice::add(Notice::ERROR, $message);
            $this->redirect('/login');
        }
        
        if (isset($_POST))
        {
            if (isset($_POST['profile']['password1']) AND isset($_POST['profile']['password2']) AND $_POST['profile']['password1'] != "" AND $_POST['profile']['password2'] != "")
            {
                if ($_POST['profile']['password1'] == $_POST['profile']['password2'])
                {
                    $this->user->password = $_POST['profile']['password1'];
                    $message = 'Successfully Changed Password';
                    Notice::add(Notice::SUCCESS, $message);
                }
                else
                {
                    $message = 'Passwords did not match';
                    Notice::add(Notice::ERROR, $message);
                }           
            }
            if (isset($_POST['profile']['username']) AND $_POST['profile']['username'] != $this->user->username)
            {
                $this->user->username = $_POST['profile']['username'];
                $message = 'Successfully Changed Username';
                Notice::add(Notice::SUCCESS, $message);
            }
            if (isset($_POST['profile']['email']) AND $_POST['profile']['email'] != $this->user->email)
            {
                $this->user->email = $_POST['profile']['email'];
                $message = 'Successfully Changed Email';
                Notice::add(Notice::SUCCESS, $message);
            }
            
            $this->user->save();    
        }
        
        $this->template->body = $view;
    }
    
    public function action_check_email()
    {
        $email = $_GET['register']['email'];
        $user = ORM::factory('User')->where('email', '=', $email)->find();
        if ($user->id == 0)
        {
            echo 'true';
        }
        else
        {
            echo 'false';
        }
        die();
    }
    
    public function action_check_username()
    {
        $username = $_GET['register']['username'];
        $user = ORM::factory('User')->where('username', '=', $username)->find();
        if ($user->id == 0)
        {
            echo 'true';
        }
        else
        {
            echo 'false';
        }
        die();
    }
	
	public function action_check_email_exists()
    {
        $email = $_GET['forgot']['username'];
        $user = ORM::factory('User')->where('email', '=', $email)->find();
        if ($user->id == 0)
        {
            echo 'false';
        }
        else
        {
            echo 'true';
        }
        die();
    }
    
    public function action_forgot_password()
    {
    	$post = Arr::get($_POST, 'forgot', array());
		$username = Arr::get($post, 'username', false);
		
		if ($username)
		{
			$user = ORM::factory('User')->where('email', '=', $username)->or_where('username', '=', $username)->find();
			if ($user->loaded())
			{
				$user->reset_code = md5($username.time());
				$user->save();
				
				$to = array($user->email => $user->username);
	            $from = array('noreply@'.Kohana::$config->load('website')->get('url') => Kohana::$config->load('website')->get('site_name'));
				// $from = array('noreply@templestudiosinc.com' => Kohana::$config->load('website')->get('site_name'));  
	            $subject = 'Reset Your Password';
	            $message = 'To reset your password, click on the following link. If you did not request this password reset, please ignore this email.<br/><br/>';
				$message.= HTML::anchor('http://'.Kohana::$config->load('website')->get('url') .'/auth/reset_password/'.$user->reset_code);
	            $mailer = Mailer::instance();
	            $mailer->to($to);
	            $mailer->from($from);
	            $mailer->subject($subject);
	            $mailer->html($message);
	            $result = $mailer->send();
	            
	            $message = 'Your password reset has been sent to '.$user->email.'. Please check your email to reset your password.';
	            Notice::add(Notice::SUCCESS, $message);
	            $this->redirect('/login');
			}
		}
		
        $view = View::factory('auth/forgot');
        $this->template->body = $view;
    }
    
    public function action_reset_password()
    {
    	$reset_code = $this->request->param('id');
		
		$user = ORM::factory('User')->where('reset_code', '=', $reset_code)->find();
		if ($user->loaded())
		{
			$view = View::factory('auth/reset');
			$view->reset_user = $user;
			$view->reset_code = $reset_code;
        	$this->template->body = $view;
		}
		else
		{
			Notice::add(Notice::ERROR, 'Invalid reset token');
            $this->redirect('/login');
		}
    }
	
	public function action_process_reset()
	{
		$reset = Arr::get($_POST, 'reset', false);
		
		if ($reset)
		{
			$reset_code = Arr::get($reset, 'reset_code');
			$user = ORM::factory('User')->where('reset_code', '=', $reset_code)->find();
			
			$user->reset_code = '';
			$user->password = Arr::get($reset, 'new_password');
			$user->save();
			
			Notice::add(Notice::SUCCESS, 'Password Saved.');
		}
		else
		{
			Notice::add(Notice::ERROR, 'Password not Saved.');
		}
		$this->redirect('account/password');
	}

    public function generatePassword($length=9, $strength=0)
    {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }
     
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }
    
    public function action_delete_account()
    {
        $request = Request::initial();
        
        $activation_code = Arr::get($_GET, 'activation_code', false);
        
        if ($activation_code)
        {
            $email = AuthHelper::decypher_activation_code($activation_code);
            
            $user = ORM::factory('User')->where('email', '=', $email)->find();
            
            if ($user->id > 0)
            {
                if ( ! $user->has('roles', ORM::factory('Role', 1)))
                {
                    $user->delete();
                    
                    $message = 'You have deleted your account.';
                    Notice::add(Notice::SUCCESS, $message);
                    $this->redirect('/');
                }
                else
                {
                    $message = 'This account ('.$user->username.') has already been activated.';
                    Notice::add(Notice::ERROR, $message);
                    $this->redirect('/');
                }
            }
            else
            {
                $message = 'No account exists with that email address.';
                Notice::add(Notice::ERROR, $message);
                $this->redirect('/');
            }
        }
    }
    
    public function action_activate_account()
    {
        $request = Request::initial();
        $auth = Auth::instance();
        
        $activation_code = Arr::get($_GET, 'activation_code', false);
        
        if ($activation_code)
        {
            $email = AuthHelper::decypher_activation_code($activation_code);
            
            $user = ORM::factory('User')->where('email', '=', $email)->find();
            
            if ($user->id > 0)
            {
                if ( ! $user->has('roles', ORM::factory('Role', 1)))
                {
                    $user->add('roles', ORM::factory('Role', 1));
                    
                    $auth->force_login($user);
                    
                    $message = "You have been logged in. Welcome ".$user->username.'.';
                    Notice::add(Notice::SUCCESS, $message);
                    $this->redirect('/profile');
                }
                else
                {
                    $message = 'This account ('.$user->username.') has already been activated.';
                    Notice::add(Notice::ERROR, $message);
                    $this->redirect('/');
                }
            }
            else
            {
                $message = 'No account exists with that email address.';
                Notice::add(Notice::ERROR, $message);
                $this->redirect('/');
            }
        }
    }
} // End Auth
