<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Oauthuser extends ORM {
   protected $_belongs_to = array(
	    'user' => array(
	        'model'   => 'User',
	        'foreign_key' => 'user_id',
	    ), 	    
    );
}