<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Malt_Core extends Controller_Template {
	
	public $template_base = '';
	public $auth_required = array();
    public $page_title;
	public $secure = false;
 
    public function before()
    {
		if (Kohana::find_file('vendor', 'autoload'))
		{
			require Kohana::find_file('vendor', 'autoload');
		}
		
		// Change the default cache driver to memcache
		Cache::$default = 'memcache';
		
    	// Auth and Logged In status
        $this->auth = Auth::instance();
        $logged_in = $this->auth->logged_in();
        $this->logged_in = $logged_in;
		
		// Setting up Template
		$ajax = $this->request->is_ajax();
		$rss = Arr::get($_GET, 'rss', false);
		
		if ($this->template_base == '')
		{
			if ($ajax !== false)
			{
				$this->template_base = 'ajax';
				
			}
			elseif($rss !== false)
			{
				$this->template_base = 'rss';
			}
			else
			{
				$this->template_base = 'default';
			}
		}
		// XSS Security
		$_REQUEST = Security::xss_clean($_REQUEST);
		$_GET = Security::xss_clean($_GET);
		$_POST = Security::xss_clean($_POST);
		
		// Establishing Site Name base
        $this->site_name = '';
        $this->application = str_replace('application/', '', APPLICATION);
        $this->template = $this->application.'/templates/'.$this->template_base.'/layout';
        parent::before();
		
		// Setting Application
		
		// Setting Request variables for later use
        $request = Request::initial();
        $this->requested_controller = $request->controller();
        $this->requested_action = $request->action();
		$this->requested_uri = $request->uri();
        
		// Attaching database config
        $config = Kohana::$config->attach(new Config_Database);
        
		// Setting global site name, url, maintenance and temple studios core version
        $this->site_name = Kohana::$config->load('website')->get('site_name');
        $this->url = Kohana::$config->load('website')->get('url');
        $this->maintenance = (bool) Kohana::$config->load('website')->get('maintenance');
		$this->malt_version = Kohana::$config->load('malt')->get('version');
		$this->customer_url = Kohana::$config->load('website')->get('url');
		$this->admin_url = 'admin.'.Kohana::$config->load('website')->get('url');
		
		// Establishing protocol (http/https)
		$this->protocol = 'http';
        $https = Arr::get($_SERVER, 'HTTPS', 'off');
        if ($https == 'on')
        {
            $this->protocol = 'https';
        }

        
		$logged_in = false;
		if ( ! $this->logged_in)
		{
			$logged_in = false;
		}
		else
		{
			if (count($this->auth_required) > 0)
			{
				foreach ($this->auth_required as $auth_required_role)
				{
					if ($this->auth->logged_in($auth_required_role))
					{
						$logged_in = true;
					}
				}
				
				if ( ! $logged_in)
		        {
		            Notice::add(Notice::ERROR, 'You do not have permission to access '.ucfirst($this->requested_controller).'.');
		            $this->redirect('/');
		        }
			}
		}
		
		if ($logged_in != true AND $this->requested_controller != ucfirst($this->application).'_Auth' AND count($this->auth_required) > 0)
		{
			Notice::add(Notice::INFO, 'Please login.');
            $this->redirect($this->application.'_auth/login');
		}
		
		$this->check_for_security();
		
		if ($this->logged_in == true)
        {
            $this->user = $this->auth->get_user();
        }
        else
        {
            $this->user = ORM::factory('User');
        }
		
		$this->title = Format::page_title($this->site_name);
		$this->page_title = $this->title;
		
        $this->navigation = Kohana::$config->load('navigation.'.$this->application);
        $this->header_vars = '';
        
        // Establishing template structure
		$this->template->header = View::factory($this->application.'/templates/'.$this->template_base.'/header');
		$this->template->html_header = View::factory($this->application.'/templates/'.$this->template_base.'/html_header');
		$this->template->footer = View::factory($this->application.'/templates/'.$this->template_base.'/footer');
		$this->template->pre_body = '';
		$this->template->body = View::factory($this->application.'/index');
        
        if ($this->maintenance)
        {
            $this->template->body = View::factory('maintenance');
			$this->pass_variables_to_template();
            echo $this->template->render();
            die();
        }
		$this->pass_variables_to_template();
    }

    public function after()
    {
        $this->pass_variables_to_template();
        parent::after();
		
		$ajax = $this->request->is_ajax();
		
		if ( ! $ajax AND $this->application != 'admin' AND Request::is_bot() == false)
		{
			$pageview = ORM::factory('Pageview');
			$pageview->page_url = Request::detect_uri();
			if ($this->user->id)
			{
				$pageview->user_id = $this->user->id;
			}
			$pageview->session_id = session_id();
			$pageview->date_viewed = date('Y-m-d H:i:s');
			$pageview->save();
		}
    }

	private function pass_variables_to_template()
	{
		$template_parts = array('', 'header', 'html_header', 'body', 'footer');
		$variables = array(
			'title', 'page_title', 'site_name', 'protocol', 'logged_in',
			'user', 'requested_controller', 'requested_action', 'requested_uri',
			'header_vars', 'navigation', 'malt_version', 'application'
		);
		
		foreach ($template_parts as $template_part)
		{
			foreach ($variables as $variable)
			{
				if ($template_part == '')
				{
					$variable_variable = '$this->template->'.$variable;
				}
				else
				{
					$variable_variable = '$this->template->'.$template_part.'->'.$variable;
				}
				try
				{
					eval($variable_variable.' = $this->'.$variable.';');
				}
				catch(Exception $e)
				{
					// 
				}
			}
		}
	}
	
	public function check_for_security()
	{
		if ($this->protocol == 'https' AND $this->secure == false)
        {
            $this->redirect(URL::site($_SERVER['REQUEST_URI'], 'http'));
        }
		elseif ($this->protocol != 'https' AND $this->secure == true)
        {
            $this->redirect(URL::site($_SERVER['REQUEST_URI'], 'https'));
        }
	}

	public function action_handle_universal_upload()
	{
		ini_set('upload_max_filesize', '2048m');
    	ini_set('memory_limit', '-1');
		
    	$id = $this->request->param('id');
		
        require Kohana::find_file('vendor', 'jquery_file_uploader/upload.class', 'php');
        $upload_options = array(
            'script_url' => '/_media/common/jquery_file_uploader/',
            'upload_dir' => '_media/uploads/',
            'upload_url' => '/_media/uploads/',
            'image_versions' => array(
                'thumbnail' => array(
                    'upload_dir' => '_media/uploads/thumbnails/',
                    'upload_url' => '/_media/uploads/thumbnails/',
                    'max_width' => 80,
                    'max_height' => 80
                )
            )
        );
        
        if (isset($_FILES) AND count($_FILES) > 0) {
            foreach ($_FILES as $file_key => $file_value)
            {
                $param_name = $file_key;
                break;
            }
            
            $upload_options['param_name'] = $param_name;
        }
        
        $upload_handler = new UploadHandler($upload_options);
        
        header('Pragma: no-cache');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

        switch ($_SERVER['REQUEST_METHOD'])
        {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $upload_handler->get();
                break;
            case 'POST':
				$files = Arr::get($_FILES, 'files', array());
				$names = Arr::get($files, 'name', array());
				foreach ($names as $key => $name)
				{
					$name = urldecode($name);
					$name = str_replace(array(',', '?', '!', '"', "'", '|'), '', $name);
					$name = str_replace(array(' ', '(', ')', '-'), '_', $name);
					$name = str_replace('_.', '.', $name);
					$name = preg_replace('/[_]+/', '_', $name);
					$_FILES['files']['name'][$key] = $name;
				}
                if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
                    $upload_handler->delete();
                }
                else
                {
                    $upload_handler->post();
                }
                break;
            case 'DELETE':
                $upload_handler->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
        die();
	}
	
	public function action_universal_upload_complete()
	{
		$id = $this->request->param('id');
		
		$user_type = Arr::get($_GET, 'usertype');
        $url = urldecode(Arr::get($_GET, 'url'));
        $url_parts = pathinfo($url);
        $type = Arr::get($_GET, 'type');
        
        $asset_type = explode('/', $type);
        $asset_type = $asset_type[0];
		$img_extensions = array('jpg', 'png', 'gif','tiff', 'jpeg');
		
        if ($asset_type == 'application')
        {
            // $asset_type = explode('/', $type);
            // $asset_type = $asset_type[1];
			
			$asset_type = 'raw';
        }

		if ($asset_type == 'text')
        {
			$asset_type = 'raw';
        }
        
		if ($id !== null)
		{
			$asset = ORM::factory('Asset', $id);
			$replace = true;
		}
		else
		{
			if ($user_type)
			{
				$asset = ORM::factory('Asset');
				$asset->title = $url_parts['filename'];
		        $asset->type = $asset_type;
		        $asset->user_type = $user_type;
		        $asset->save();
				$replace = false;
				
				if ($user_type == 'customer')
				{
					$user_assets = $this->user->assets->find_all();
					foreach ($user_assets as $user_asset)
					{
						$this->user->remove('assets', $user_asset);
						$user_asset->delete();
					}
					
					$this->user->add('assets', $asset);
				}
			}
			else 
			{
				$asset = ORM::factory('Asset');
				$asset->title = $url_parts['filename'];
		        $asset->type = $asset_type;
		        $asset->user_type = 'admin';
		        $asset->save();
				$replace = false;
			}
			
		}
        
        $file = ORM::factory('File');
        $file->asset_id = $asset->id;
        $file->type = 'upload';
        $file->url = $url;
        $file->storage = 'local';
        $file->save();
		
		if ($asset->type == 'video')
		{
			if (in_array(strtolower($url_parts['extension']) , $img_extensions))
			{
				$asset->process_uploaded_asset($asset_type = 'image', $replace, $video_image_replace = true);
			}
			else
			{
				$asset->process_uploaded_asset($asset_type, $replace, $video_image_replace = false);
			}
		}
		else 
		{
			$asset->process_uploaded_asset($asset_type, $replace, $video_image_replace = false);
		}
		
        
        $return = array('asset_id' => $asset->id);
        echo json_encode($return);
        die();
	}

	public function action_save_universal_image()
	{
		$redirect = Arr::get($_POST, 'urlredirect');
		Notice::add(Notice::SUCCESS, 'Image Saved.');
		if($redirect)
		{
			$this->redirect($redirect);
		}
		else 
		{
			$this->redirect('/');
		}
	}

	public function action_get_universal_assets()
    {
    	$type = Arr::get($_GET, 'type', false);
        $content_id = Arr::get($_GET, 'content_id', '');
        $asset_ids = Arr::get($_GET, 'asset_ids', '');
        $asset_ids = explode(',', $asset_ids);
        
		echo '<table class="table table-striped table-hover">';
		echo '<tbody>';
        if (count($asset_ids) > 0)
        {
            foreach ($asset_ids as $asset_id)
            {
                if ($asset_id != 0 AND $asset_id != '')
                {
                    $asset = ORM::factory('Asset')->where('id', '=', $asset_id)->find();
					
					$ajax_asset = View::factory('universalupload/ajax_asset');
					$ajax_asset->type = $type;
					$ajax_asset->action = 'remove';
					$ajax_asset->asset = $asset;
					echo $ajax_asset;
                }
            }
        }
        echo '</tbody>';
		echo '</table>';
        die();
    }

}