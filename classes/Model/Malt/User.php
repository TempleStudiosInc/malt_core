<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Model_Malt_User extends Model_Auth_User {
	protected $_has_many = array(
        'oauth_users' => array(
            'model' => 'Oauthuser',
            'foreign_key' => 'user_id',
        ),
        'roles' => array(
        	'model' => 'Role',
        	'through' => 'roles_users'
		),
        'user_tokens' => array(
        	'model' => 'User_Tokens'
		),
        'addresses' => array(
        	'model' => 'Address'
		),
		'orders' => array(
			'model' => 'Order'

		),
		'assets' => array(
			'model' => 'Asset',
			'through' => 'assets_users'
		),
		'credit_cards' => array(
		  'model' => 'Users_Creditcard'
        )

    );
		
	protected $_has_one = array(
		'profile' => array(),
	);
	
	private $password_confirm = null;
	
	public function get_user_image($size = '')
	{
		if ($size != '')
		{
			$user_asset = $this->assets->where('type', '=', 'image')->find();
			
			if ($user_asset->loaded())
			{
				$user_asset = $user_asset->files->where('type', '=', $size)->find()->url;
				if ($user_asset)
				{
					return $user_asset;
				}
				else 
				{
					return false;
				}
				
			}
			else
			{
				return false;
			}
		}
		else
		{
			$user_asset = $this->user->assets->where('type', '=', 'image')->find();
			if ($user_asset->loaded())
			{
				return $user_asset;
			}
			else
			{
				return false;
			}
		}
		
		
	}
}