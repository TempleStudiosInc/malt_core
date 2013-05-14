<?php defined('SYSPATH') OR die('No direct access allowed.');

abstract class Auth extends Kohana_Auth {
	protected function complete_login($user)
	{
		// Store username in session
		$this->_session->set($this->_config['session_key'], $user);

		return TRUE;
	}
}