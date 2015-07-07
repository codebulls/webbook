<?php

class AdminwebbookController extends ControllerBase
{

	public function indexAction()
	{
		$bu = User::getUsers("company != '---'", "company");
		$pu = User::getUsers("company = '---'", "lastname");
		
		
		$this->view->setVars(array(
			'businessusers' => $bu,
			'privateusers' => $pu
			
		));
	}
	
	public function editAction($wid, $pid, $uid)
	{
		$this->view->setVars(array(
			'webbook' => Webbook::findFirstById($wid),
			'currentproject' => Project::findFirstById($pid),
			'projects' => Project::find("user_id = ".$uid)
		));
	}
	
	public function addwbAction()
	{
		$this->view->setVars(array(
			'projects' => Project::find(),
			'user' => User::find()
		));
	}
	
	public function chfileAction($wid, $route)
	{
		if(isset($_POST['action']) && $_POST['action'] == 'changefile' && !empty($wid) && is_numeric($wid))
		{
			$webbook = Webbook::findFirstById($wid);
			
			$pdfpath = getcwd()."/customers/".$webbook->customer_location_first."/pdfs";
			$pdf = $pdfpath."/".basename($_FILES["pdffile"]["name"]);
			
			$fileType = pathinfo($pdf,PATHINFO_EXTENSION);
			if($fileType == "pdf")
			{
				if(move_uploaded_file($_FILES["pdffile"]["tmp_name"], $pdf))
				{
					$webbook->pdfpath = $pdf;
					
					if($webbook->update())
					{
						$this->response->redirect($route);
						return;
					}
					else
					{
						print_r('Fehler!!!');
					}
				}
				else
				{
					print_r('Error move_uploaded_file');exit;
				}
			}
			else
			{
				print_r('Filetype not pdf');exit;
			}
		}
	}
	
	public function savewebbookAction($wid, $route)
	{
		if(isset($_POST['action']) && $_POST['action'] == 'saveadminwebbook' && !empty($wid) && is_numeric($wid))
		{
			$webbook = Webbook::findFirstById($wid);
			$webbook->title = isset($_POST['wbtitle']) && !empty($_POST['wbtitle']) ? $_POST['wbtitle'] : $webbook->title;
			$webbook->project_id = isset($_POST['wbproject']) && !empty($_POST['wbproject']) ? $_POST['wbproject'] : $webbook->project_id;
			
			
			if($webbook->update())
			{
				$this->response->redirect($route);
				return;
			}
			else
			{
				print_r('Fehler beim Updaten');
			}
		}
	}
	
}