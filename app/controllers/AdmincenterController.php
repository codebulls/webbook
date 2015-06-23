<?php

class AdmincenterController extends ControllerBase
{
	public function indexAction()
	{
		$s = $this->session->get('a_auth');
		$user = User::findFirstById($s['id']);

		$this->view->setVars([
			'user' => $user
		]);
	}
}