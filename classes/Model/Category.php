<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Category extends ORM {
	protected $_has_many = array(
	    'assets' => array(
	        'model' => 'Asset',
	        'through' => 'assets_categories',
	    ),
	    'products' => array(
	        'model' => 'Product',
	        'through' => 'products_categories',
	    ),
	    'blog_posts' => array(
	        'model' => 'Blogs_Post',
	        'through' => 'blogs_posts_categories',
	    ),
    );
	
	protected $_belongs_to = array(
		'parent' => array(
	    	'model' => 'Category',
	    	'foreign_key' => 'parent_id'
		)
	);
	
	public function children($category_id = false)
	{
		if ( ! $category_id)
		{
			$category_id = $this->id;
		}
		return ORM::factory('Category')->where('parent_id', '=', $category_id)->find_all();
	}
    
    public function get_category_tree($category_id = null)
    {
        $categories = array();
        if ($category_id != null)
        {
            $parent_category = ORM::factory('Category', $category_id);
			$child_categories = $this->children($category_id);
            foreach ($child_categories as $child_category)
            {
                $sub_children = $this->get_category_tree($child_category->id);
                if ($sub_children == array())
                {
                    $categories[$child_category->id] = $child_category->name;
                }
                else
                {
                    $categories[$child_category->id] = $this->get_category_tree($child_category->id);
                }
            }
        }
        else
        {
            $parent_categories = ORM::factory('Category')->where('parent_id', '=', 0)->find_all();
            
            foreach ($parent_categories as $parent_category)
            {
                $categories[$parent_category->name] = $this->get_category_tree($parent_category->id);
            }
        }
        
        return $categories;
    }

    public function add_categories($categories, $object)
    {
        foreach ($object->categories->find_all() as $category)
        {
            $object->remove('categories', $category);
        }
        
        if (is_array($categories))
        {
            foreach ($categories as $category)
            {
                $category = ORM::factory('Category', $category);
				if ($category->loaded())
				{
					if ( ! $object->has('categories', $category))
	                {
	                    $object->add('categories', $category);
	                }
	                
	                if ($category->parent_id != 0 AND $category->level > 1)
	                {
	                    $parent_category = ORM::factory('Category', $category->parent_id);
	                    if ( ! $object->has('categories', $parent_category))
	                    {
	                        $object->add('categories', $parent_category);
	                    }
	                }
				}
            }
        }
    }
	
	public function get_all_categories()
	{
		$categories = array(0 => 'Select A Category');
		$categories_orm = ORM::factory('Category')->find_all();
		foreach ($categories_orm as $orm)
		{
			$categories[$orm->id] = $orm->name;
		}
		return $categories;
	}
}