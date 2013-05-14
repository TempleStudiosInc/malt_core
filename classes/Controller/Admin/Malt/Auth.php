<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Admin_Malt_Auth extends Controller_Admin_Website {
    
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
        
        $site_url = Arr::get($_SERVER, 'SERVER_NAME', Kohana::$config->load('website')->get('url'));
        if ($this->protocol != 'https' AND strstr($site_url, 'admin') === false)
        {
            $this->redirect('https://'.$site_url.'/login');
        }
        
        $view = View::factory('auth/admin/login');
        
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
        
        $user = ORM::factory('User')->where('username', '=', $post['username'])->or_where('email', '=', $post['username'])->find();
        
        if ($login_result == true)
        {
            $user = $this->auth->get_user();
            $message = "You have been logged in. Welcome ".$user->username.'.';
            Notice::add(Notice::SUCCESS, $message);
            $session = Session::instance();
            $redirect_url = $session->get('referrer_url', '/');
            $session->delete('referrer_url');
            $this->redirect($redirect_url);
        }
        elseif ( ! $user->has('roles', ORM::factory('Role', 1)))
        {
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
    
    public function action_forgot_password()
    {
        $view = View::factory('auth/forgot');
        $this->template->body = $view;      
    }
    
    public function action_reset_password()
    {
        $post = $_POST['reset']['email'];
        $user = ORM::factory('User')->where('email', '=', $post)->find();
    
        if ($user->loaded() AND $user->id != 0)
        {
            $new_pass = $this->generatePassword($length = 8, $strength = 2);
            $user->password = $new_pass;
            $user->save();
            
            $to = array($user->email => $user->username);
            $from = array('noreply@'.Kohana::$config->load('website')->get('url') => Kohana::$config->load('website')->get('site_name')); 
            $subject = 'Reset Your Password';
            $message = 'Your new password is: '.$new_pass.' <br/> You can change this by <a href="http://';
            $message.= Kohana::$config->load('website')->get('url');
            $message.= '/login">logging in</a> , navigating to your account, and changing your password.';
            $mailer = Mailer::instance();
            $mailer->to($to);
            $mailer->from($from);
            $mailer->subject($subject);
            $mailer->html($message);
            $result = $mailer->send();
            
            $message = 'Your new password has been sent to '.$user->email.'. Please check your email to retrieve your password.';
            Notice::add(Notice::SUCCESS, $message);
            $this->redirect('/login');
        }
        else
        {
            $message = 'Email Address Not Found.';
            Notice::add(Notice::ERROR, $message);
            $this->redirect('/forgot_password');
        }
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
} // End Auth
