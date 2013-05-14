<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Tag extends ORM {
   protected $_has_many = array(
	    'assets' => array(
	        'model'   => 'Asset',
	        'through' => 'assets_tags',
	    ),
    );
    
    public function add_tags($tags, $object)
    {
        foreach ($object->tags->find_all() as $tag)
        {
            $object->remove('tags', $tag);
        }
        
        foreach ($tags as $tag)
        {
            $tag_orm = ORM::factory('Tag')->where('name', '=', $tag)->find();
            if ($tag_orm->id == 0)
            {
                $tag_orm->name = $tag;
                $tag_orm->save();
            }
            
            if ( ! $object->has('tags', $tag_orm))
            {
                $object->add('tags', $tag_orm);
            }
        }
    }
}