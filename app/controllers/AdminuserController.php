<?php

class AdminuserController extends ControllerBase
{
	public function indexAction()
	{
		$this->view->setVars([
			'loggedadmin' => $this->getAdmin(),
			'customers' => User::find("user_group = 1"),
			'admins' => User::find("user_group = 2")
		]);
	}

	public function adduserAction()
	{
        $this->view->setVars([
            'tariffe' => Tariff::find(),
            'lands' => Land::find()
        ]);
	}

	public function addadminAction()
	{

	}
	
	public function updateadminAction($uid, $route)
	{
		if(!empty($uid) && !empty($route) && isset($_POST['action']) && $_POST['action'] == 'updateadmin')
		{
			$error = array();
			$user = User::findFirstById($uid);
			foreach($_POST as $k => $v)
			{
				$user->$k = isset($k) && !empty($v) ? $v : $error[] = $k;
			}
			if($user->update())
			{
				$this->response->redirect($route);
				return;
			}
		}
		//Weiterleitung an eine Fehlerseite
	}

	public function updateAction($uid, $route)
	{
		$msg = '';

		if(!empty($uid) && !empty($route) && isset($_POST['action']) && $_POST['action'] == 'updatecustomer')
		{

			$user = User::findFirstById($uid);

			foreach($_POST as $k => $v)
			{
				if(!empty($v))
				{
					$user->$k = $v;
				}
			}

			if($user->update())
			{
				$this->response->redirect($route);
				return;
			}
		}

		$this->dispatcher->forward(array(
			"controller" => "errors",
			"action" => "showerror",
			"params" => $msg
		));
	}

	public function deleteAction($uid, $route)
	{
		if(User::findFirstById($uid)->delete())
		{
			$this->response->redirect($route);
			return;
		}

	}

	public function checkadmindataAction()
	{
		$this->view->disable();
		$error = array();
		foreach($_POST as $k=>$v)
		{
			if(empty($v))
			{
				$error[] = $k;
			}
		}

		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$error[] = 'email';
		}
	
		echo count($error) < 1 ? json_encode(array("res" => "ok")) : json_encode($error);

	}

	public function checkadduserdataAction()
	{
		$this->view->disable();
        $error = array();
		foreach ($_POST as $k => $v) {
			if(empty($v))
			{
				$error[] = $k;
			}
		}
		
		echo count($error) < 1 ? json_encode(array("res" => "ok")) : json_encode($error);
		
	}

	public function saveadminAction($route)
	{
		$error = array();

		if(isset($_POST['action']) && $_POST['action'] == 'saveadmin')
		{
			$user = new User();
			$user->email = isset($_POST['aaemail']) && !empty($_POST['aaemail']) ? $_POST['aaemail'] : $error[] = 'email';
			$user->password = password_hash($_POST['aapassword'], PASSWORD_BCRYPT);
			$user->prefix = isset($_POST['aaprefix']) && !empty($_POST['aaprefix']) ? $_POST['aaprefix'] : '';
			$user->firstname = isset($_POST['aafirstname']) && !empty($_POST['aafirstname']) ? $_POST['aafirstname'] : $error[] = 'firstname';
			$user->lastname = isset($_POST['aalastname']) && !empty($_POST['aalastname']) ? $_POST['aalastname'] : $error[] = 'lastname';
			$user->company = '---';
			$user->phone = '---';
			$user->street = '---';
			$user->zip = 0;
			$user->city = '---';
			$user->land = 7;
			$user->steuerid = '---';
			$user->user_group = 2;
			$user->hidden = 0;
			$user->deleted = 0;

			if($user->create() && count($error) < 1)
			{
				$this->response->redirect($route);
				return;
			}
			
			print_r($user->getMessages());
		}
	}

	public function saveuserAction()
	{
		$error = array();
		if(isset($_POST['action']) && $_POST['action'] == 'save')
		{
			$user = new User();

			$user->prefix = isset($_POST['aprefix']) ? (string)$_POST['aprefix'] : '';

			$user->firstname = isset($_POST['afirstname']) && !empty($_POST['afirstname']) ? $_POST['afirstname'] : $error[] = 'firstname';
			$user->lastname = isset($_POST['alastname']) && !empty($_POST['alastname']) ? $_POST['alastname'] : $error[] = 'lastname';
			$user->email = isset($_POST['aemail']) && !empty($_POST['aemail']) ? $_POST['aemail'] : $error[] = 'email';
			$user->password = password_hash($_POST['apassword'], PASSWORD_BCRYPT);
			$user->phone = isset($_POST['aphone']) && !empty($_POST['aphone']) ? $_POST['aphone'] : '---';
			$user->company = isset($_POST['acompany']) && !empty($_POST['acompany']) ? $_POST['acompany'] : '---';
			$user->street = isset($_POST['astreet']) && !empty($_POST['astreet']) ? $_POST['astreet'] : $error[] = 'street';
			$user->zip = isset($_POST['azip']) && !empty($_POST['azip']) ? $_POST['azip'] : $error[] = 'zip';
			$user->city = isset($_POST['acity']) && !empty($_POST['acity']) ? $_POST['acity'] : $error[] = 'city';
			$user->steuerid = isset($_POST['asteuerid']) && !empty($_POST['asteuerid']) ? $_POST['asteuerid'] : '---';
			$user->land = isset($_POST['aland']) && !empty($_POST['aland']) ? $_POST['aland'] : $error[] = 'land';

			$user->user_group = 1;
			$user->hidden = 0;
			$user->deleted = 0;
			
			$active = isset($_POST['setactive']) && $_POST['setactive'] == 1 ? 1 : 0;

			if($user->create())
			{
				$this->dispatcher->forward(array(
					"controller" => "adminaccount",
					"action" => "create",
					"params" => array('tariff' => $_POST['atariff'], 'active' => $active)
				));
				return;
			}
			
			print_r($user->getMessages());

		}
	}
}
