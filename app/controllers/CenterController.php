<?php

class CenterController extends ControllerBase
{
	public function indexAction()
	{
		$s = $this->session->get('c_auth');
		$user = User::findFirstById($s['id']);

		$cForAccount = "user_id = ".$user->id;
		$account = Account::findFirst(array($cForAccount));

		$cForWebbook = "account_id = ".$account->id;
		$webbooks = Webbook::find(array($cForWebbook));


		$this->view->setVars([
			'user' => $user,
			'anzahlwebbooks' => count($webbooks)
		]);
	}
}