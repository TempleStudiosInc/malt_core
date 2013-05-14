<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tag extends Controller_Admin_Website {
	
	public function before()
    {
        parent::before();
        
        $model_name = 'Tag';
		$semantic_model_name = 'Tag';
        $plural_model_name = Inflector::plural($model_name);
		$semantic_plural_model_name = Inflector::plural($semantic_model_name);
        $this->template->content_title = 'Tags';
        $this->page_title = ' ';
        $this->model_name = $model_name;
        $this->plural_model_name = $plural_model_name;
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
    	$breadcrumb = View::factory('tag/admin/breadcrumb');
		$breadcrumb_items = array();
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		
        $model_name = $this->model_name;
		
        $view = View::factory(strtolower($model_name).'/admin/index');
        $view->model_name = $this->model_name;
        
        $request = Request::initial();
        $query_array = $request->query();
        $view->query_array = $query_array;
        
        $search_form = array(
            'name' => ''
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
                
        $tags = $this->database_search($model_name, $form);
        $result_count = $tags->count_all();
        
        $tags = $this->database_search($model_name, $form);
        
        $page = Arr::get($_GET, 'page', 1);
        
        if (Arr::get($_GET, 'view_all', false))
        {
            $page_limit = $result_count;
            
            $view_all_button = HTML::anchor('/admin_tag', 'Paginate List', array('id' => 'abutton', 'class' => 'btn btn-success'));
            $view->view_all_button = $view_all_button;
        }
        else
        {
            $page_limit = 20;
            $offset = ($page-1)*$page_limit;
            $tags->limit($page_limit)->offset($offset);
            
            $view_all_button = HTML::anchor('/admin_tag?view_all=true', 'View All', array('id' => 'abutton', 'class' => 'btn btn-success'));
            $view->view_all_button = $view_all_button;
        }
        
        $pagination = Pagination::factory(array(
            'items_per_page' => $page_limit,
            'total_items' => $result_count,
        ));
        $view->pagination = $pagination;
        
        $order_by_value = Arr::get($_GET, 'order_by', 'id');
        $sorted = Arr::get($_GET, 'sorted', 'asc');
        
        $tags = $tags->order_by($order_by_value,$sorted)->find_all();
        
        $view->tags = $tags;
        
        $this->template->body = $view;
    }

	public function action_edit()
    {
    	$breadcrumb = View::factory('tag/admin/breadcrumb');
		$breadcrumb_items = array(
			'/admin_tag/edit' => 'Edit Tag',
		);
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		
        $action = 'edit';
        $model_name = $this->model_name;
        
        $view = View::factory(strtolower($model_name).'/admin/add_edit');
        $view->model_name = $this->model_name;
        $view->action = $action;
        
        $tag_id = $this->request->param('id');
        
        $tag = ORM::factory($model_name, $tag_id);
        $view->tag = $tag;
        
        $this->template->body = $view;
    }
	
	public function action_save()
    {
    	$model_name = $this->model_name;
		
        $post = Arr::get($_POST, 'tag');
        foreach ($post as $key => $value)
        {
            switch ($key)
            {
                case 'id':
                    if ($value == 0)
                    {
                        $tag = ORM::factory(ucfirst($this->model_name));
                    }
                    else
                    {
                        $tag = ORM::factory(ucfirst($this->model_name), $value);
                    }
                    break;
                default:
                    $tag->$key = $value;
                    break;
            }
        }
        $tag->save();
        
        Notice::add(Notice::SUCCESS, $model_name.' Saved.');
        $this->redirect('/admin_tag/');
    }

	public function action_delete()
    {
    	$model_name = $this->model_name;
		
        $tag_id = $this->request->param('id');
        
        if ($tag_id)
        {
            $tag = ORM::factory($model_name, $tag_id);
			
			$assets = $tag->assets->find_all();
			foreach ($assets as $asset)
			{
				$asset->remove('tags', $tag);
			}
			
            $tag->delete();
            Notice::add(Notice::SUCCESS, $model_name.' Deleted.');
            $this->redirect('/admin_tag');
        }
        else
        {
            Notice::add(Notice::ERROR, $model_name.' not found.');
            $this->redirect('/admin_tag');
        }
    }

	private function database_search($model, $params)
    {
        $model_orm = ORM::factory(ucfirst($model));
        foreach ($params as $key => $value)
        {
            if ($value != '')
            {
                $model_orm->where($key, 'like', '%'.$value.'%');
            }
        }
        return $model_orm;
    }
	
    public function action_get_tags()
    {
    	$tags = ORM::factory('Tag')->find_all();
		$tags_json = array();
		foreach ($tags as $tag)
		{
			$tags_json[] = array('tag' => $tag->name);
		}
		echo json_encode(array('tags' => $tags_json));
		die();
	}
}