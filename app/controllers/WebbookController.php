<?php

class WebbookController extends ControllerBase
{

	public function indexAction()
	{
		$cForAccount = "user_id = ".$this->gUserId();
		$account = Account::findFirst(array($cForAccount));

		$cForWebbook = "account_id = ".$account->id;
		$webbook = Webbook::find(array($cForWebbook));

		$cForProject = "user_id = ".$this->gUserId();
		$project = Project::find(array($cForProject));

		$ticket = Ticket::find("user_id = ".$this->gUserId());

		$this->view->setVars([
			'user' => $this->gUser(),
			'account' => $account,
			'webbook' => $webbook,
			'project' => $project,
			'anzahlprojekte' => count($project),
			'anzahlwebbooks' => count($webbook)
		]);
	}

	public function newAction()
	{
		$projects = Project::find("user_id = ".$this->gUserId());

		$this->view->setVars([
			'projects' => $projects
		]);
	}

	public function chwebbookAction($wid, $route)
	{
		if(isset($_POST['action']) && $_POST['action'] == 'chwebb')
		{
			$webbook = Webbook::findFirstById($wid);

			if(!empty($_POST['wbtitle']))
			{
				$webbook->title = $_POST['wbtitle'];
			}
			if(!empty($_POST['wbproject']))
			{
				$webbook->project_id = $_POST['wbproject'];
			}

			$result = $webbook->update();

			if(!$result)
			{
				print_r('Fehler!!');
			}
			else {
				$this->response->redirect($route);
			}
		}
	}
	
	
	public function checkFormDataAction()
    {
        $this->view->disable();
        $error = array();
        $p = $_POST;
        foreach($p as $k => $v)
        {
            if(empty($v))
            {
                $error[] = $k;
            }
        }

        if(count($error) < 1)
        {
            echo json_encode(array('res' => 'ok'));
        }
        else
        {
            echo json_encode($error);
        }
    }


    public function createAction()
    {
    	if(isset($_POST['action']) && $_POST['action'] == 'wbcreate')
    	{
    		$errors = array();
    		$account = Account::findFirst("user_id = ".$this->gUserId());
    		$pdfpath = getcwd()."/customers/".$account->akey."/pdfs";
    		$libpath = "http://".$_SERVER['SERVER_NAME']."/libs/";
    		$pdf = $pdfpath."/".basename($_FILES["pdffile"]["name"]);


    		if(!file_exists($pdf))
    		{

    			$fileType = pathinfo($pdf,PATHINFO_EXTENSION);
    			if($fileType == "pdf")
    			{
    				if(move_uploaded_file($_FILES["pdffile"]["tmp_name"], $pdf))
    				{
    					$webbook = new Webbook();
    					$webbook->account_id = $account->id;
    					$webbook->project_id = $_POST['project'];
                        $webbook->title = $_POST['pdfname'];
                        $webbook->pdfpath = $pdf;
                        $webbook->libpath = $libpath;
                        $webbook->customer_location_first = $account->akey;
                        $webbook->outpath = sha1(time().$account->id.$this->gUserId());
                        $webbook->full_link = '---';
                        $webbook->active = 0;
                        $webbook->convert_confirmed = 0;
                        $webbook->processing = 0;
                        $webbook->hidden = 0;
                        $webbook->deleted = 0;

                        $result = $webbook->create();

                        if(!$result)
                        {
                        	print_r($webbook->getMessages());
                        }
                        else
                        {
                        	$this->response->redirect('webbook');
                        }
    				}
    				else
    				{
    					print_r('Fehler beim Verschieben von der Datei');
    				}
    			}
    			else
    			{
    				print_r('Falscher Datei-Format');
    			}
    		}
    		else
    		{
    			print_r('Angeblich gibt es schon diese Datei oder diesen Ordner');
    		}
    	}
    }

    public function deleteAction($wid)
    {
    	$webbook = Webbook::findFirstById($wid);
    }

		public function acontrueAction($wid)
		{
			$this->view->disable();
			if(!empty($wid) && is_numeric($wid))
			{
				$webbook = Webbook::findFirstById($wid);
				$webbook->convert_confirmed = 1;
				$result = $webbook->update();

				if(!$result)
				{
					print_r('Fehler!!!');
				}
				else
				{
					$this->response->redirect("webbook");
				}
			}
		}
}
