<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	public function gUserId()
	{
		$s = $this->session->get('c_auth');
		$user = User::findFirstById($s['id']);

		return $user->id;
	}

	public function gUser()
	{
		$s = $this->session->get('c_auth');
		$user = User::findFirstById($s['id']);

		return $user;
	}
}
