<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	public function getAdminId()
	{
		$s = $this->session->get('a_auth');
		$admin = User::findFirstById($s['id']);

		return $admin->id;
	}

	public function getAdmin()
	{
		$s = $this->session->get('a_auth');
		$admin = User::findFirstById($s['id']);

		return $admin;
	}

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
