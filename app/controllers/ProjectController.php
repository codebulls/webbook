<?php

class ProjectController extends ControllerBase
{
	public function indexAction()
	{
		$cForProject = "user_id = ".$this->gUserId();
		$projects = Project::find(array($cForProject));

		$cForAccount = "user_id = ".$this->gUserId();
		$account = Account::findFirst(array($cForAccount));

		$this->view->setVars([
			'projects' => $projects,
			'user' => $this->gUser(),
			'anzahlprojekte' => count($projects)
		]);
	}

	public function createAction()
	{

		if(isset($_POST['action']) && $_POST['action'] == 'procreate')
		{
			$project = new Project();

			if(!empty($_POST['projecttitle']) && !empty($_POST['projecturl']))
			{
				debug_print_backtrace();
				$project->title = $_POST['projecttitle'];
				$project->weburl = $_POST['projecturl'];
				$project->user_id = $this->gUserId();
				$project->hidden = 0;
				$project->deleted = 0;

				$result = $project->create();

				if(!$result) 
				{
	            	print_r($project->getMessages());
	            }
	            else
	            {
	            	$this->response->redirect('project');
	            }
			}
			else
			{
				print_r('Fehler!!!');
			}
		}
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