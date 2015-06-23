<?php

class WebbookController extends ControllerBase
{
	public function indexAction()
	{
		$s = $this->session->get('c_auth');
		$user = User::findFirstById($s['id']);

		$cForAccount = "user_id = ".$user->id;
		$account = Account::findFirst(array($cForAccount));

		$cForWebbook = "account_id = ".$account->id;
		$webbook = Webbook::find(array($cForWebbook));

		$cForProject = "user_id = ".$user->id;
		$project = Project::find(array($cForProject));

		$this->view->setVars([
			'user' => $user,
			'account' => $account,
			'webbook' => $webbook,
			'project' => $project,
			'anzahlprojekte' => count($project),
			'anzahlwebbooks' => count($webbook)
		]);
	}

	public function newAction()
	{

	}

}