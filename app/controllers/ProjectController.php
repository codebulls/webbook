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

	public function deleteAction($pid)
	{
		if(isset($_POST['action']) && $_POST['action'] == 'dodelete')
		{
			$project = Project::findFirstById($pid);
			$webbooks = Webbook::find("project_id = ".$pid);

			if(count($webbooks) < 1)
			{
				$result = $project->delete();
				if(!result)
				{
					print_r('Fehler beim Löschen eines Projektes');
				}
				else
				{
					$this->response->redirect("project");
				}
			}
			else
			{
				if(!empty($_POST['wids']) && $_POST['delconfirm'] == 'ja')
				{
					$wids = array();
					$wids = explode("/", $_POST['wids']);
					$errors = array();

					foreach($wids as $K=>$v)
					{
						if(!empty($v))
						{
							$webbook = Webbook::findFirstById($v);
							$webbook->project_id = NULL;
							$result = $webbook->update();

							if(!$result)
							{
								$errors[] = $v;
							}
						}
					}
					if(count($errors) < 1)
					{
						$result = $project->delete();
						if(!$result)
						{
							print_r('Fehler beim Löschen 1');
						}
						else
						{
							$this->response->redirect("project");
						}
					}
					else {
						print_r('Fehler beim Löschen');
					}
				}
			}
		}
	}

}
