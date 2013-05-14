<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Category extends Controller_Admin_Website {

	public function before()
	{
		parent::before();
		$this->page_title = '';
		$this->model_name = 'category';
		$this->template->content_title = 'Categories';
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
		$breadcrumb = View::factory('category/admin/breadcrumb');
		$breadcrumb_items = array();
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		
		$model_name = $this->model_name;
		$view = View::factory('category/admin/index');
		$view->model_name = $model_name;
		
		$request = Request::initial();
        $query_array = $request->query();
        $view->query_array = $query_array;
		
		$search_form = array(
            'name' => '',
            'level' => '',
            'parent_id' => ''
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
		
		$categories = $this->database_search($model_name, $form);
        $result_count = $categories->count_all();
        
        $categories = $this->database_search($model_name, $form);
        
        $page = Arr::get($_GET, 'page', 1);
        
        if (Arr::get($_GET, 'view_all', false))
        {
            $page_limit = $result_count;
            
            $view_all_button = HTML::anchor('/admin_category', 'Paginate List', array('id' => 'abutton', 'class' => 'btn btn-success'));
            $view->view_all_button = $view_all_button;
        }
        else
        {
            $page_limit = 20;
            $offset = ($page-1)*$page_limit;
            $categories->limit($page_limit)->offset($offset);
            
            $view_all_button = HTML::anchor('/admin_category?view_all=true', 'View All', array('id' => 'abutton', 'class' => 'btn btn-success'));
            $view->view_all_button = $view_all_button;
        }
        
        $pagination = Pagination::factory(array(
            'items_per_page' => $page_limit,
            'total_items' => $result_count,
        ));
        $view->pagination = $pagination;
        
        $order_by_value = Arr::get($_GET, 'order_by', 'id');
        $sorted = Arr::get($_GET, 'sorted', 'asc');
        
        $categories = $categories->order_by($order_by_value,$sorted)->find_all();
        
		$view->categories = $categories;
		$this->template->body = $view;
	}

	public function action_add()
	{
		$breadcrumb = View::factory('category/admin/breadcrumb');
		$breadcrumb_items = array(
			'/admin_category/add' => 'Add Category',
		);
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		
		$action = 'add';
		$view = $this->add_edit($action);
		$this->template->body = $view;
	}

	public function action_edit()
	{
		$breadcrumb = View::factory('category/admin/breadcrumb');
		$breadcrumb_items = array(
			'/admin_category/edit' => 'Edit Category',
		);
		$breadcrumb->items = $breadcrumb_items;
		$this->template->breadcrumb = $breadcrumb;
		$id = $this->request->param('id');
		$action = 'edit';
		$view = $this->add_edit($action, $id);
		$this->template->body = $view;
	}
	
	private function add_edit($action = 'add', $id = false)
	{
		if ($id)
		{
			$category = ORM::factory(ucfirst($this->model_name), $id);
		}
		else
		{
			$category = ORM::factory(ucfirst($this->model_name));
		}
		
		$categories = ORM::factory(ucfirst($this->model_name))->where('level', '=', 1)->find_all();
		$parent_ids = array();
		foreach ($categories as $parent)
		{
			$parent_ids[$parent->id] = $parent->name;
		}
		$view = View::factory('category/admin/add_edit');
		$view->model_name = $this->model_name;
		$view->content_title = ucfirst($action).' Category';
		$view->parent_ids = $parent_ids;
		$view->category = $category;
		return $view;
	}
	
	public function action_save()
	{
		$form = Arr::get($_POST, 'form', NULL);
		if ($form)
		{
			if (isset($form['id']))
			{
				$category = ORM::factory(ucfirst($this->model_name), $form['id']);
			}
			else
			{
				$category = ORM::factory(ucfirst($this->model_name));
			}	
			
			$category->parent_id = $form['parent'];
			$category->name = $form['name'];
			$category->description = $form['description'];
			$category->level = 1;
			if ($form['parent'] != '0')
			{
				$category->level = 2;
			}			
			$category->save();
			
			$message = Text::ucfirst($this->model_name).' Saved.';
			Notice::add(Notice::SUCCESS, $message);
			$this->redirect('/admin_category');
		}
	}
	
	public function action_delete()
	{
		$id = $this->request->param('id');
		$category = ORM::factory(ucfirst($this->model_name), $id);
		
		$assets = $category->assets->find_all();
		foreach ($assets as $asset)
        {
            $category->remove('Assets', $asset);
        }
		
		$products = $category->products->find_all();
		foreach ($products as $product)
        {
            $category->remove('Products', $product);
        }
        $category->delete();
		
		Notice::add(Notice::SUCCESS, 'Category Deleted.');
		$this->redirect('/admin_category');
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
	
} // End Category