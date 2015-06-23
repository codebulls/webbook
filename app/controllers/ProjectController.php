<?php

class ProjectController extends ControllerBase
{
	public function indexAction()
	{
		$s = $this->session->get('c_auth');
		$user = User::findFirstById($s['id']);

		$cForProject = "user_id = ".$user->id;
		$projects = Project::find(array($cForProject));

		$cForAccount = "user_id = ".$user->id;
		$account = Account::findFirst(array($cForAccount));

		

		$this->view->setVars([
			'projects' => $projects,
			'anzahlprojekte' => count($projects)
		]);
	}

	public function updateAction($pid)
	{
		if(!empty($pid) && is_numeric($pid))
		{
			if(isset($_POST['action']) && $_POST['action'] == 'proupdate')
			{
				$project = Project::findFirstById($pid);
				if(!empty($_POST['projecttitle']))
				{
					$project->title = $_POST['projecttitle'];
				}
				if(!empty($_POST['projecturl']))
				{
					$project->weburl = $_POST['projecturl'];
				}

				$result = $project->update();
				if(!$result) 
				{
                	print_r($customer->getMessages());
	            }
	            else
	            {
	                $this->dispatcher->forward(array(
	                   "controller" => "project",
	                   "action"     => "index"
	                ));
	            }
			}
		}
	}

}