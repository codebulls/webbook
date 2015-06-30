<?php

class AdminuserController extends ControllerBase
{
	public function indexAction()
	{

	}

	public function adduserAction()
	{
		$t = Tariff::find();
		$l = Land::find();
        $this->view->setVars([
            'tariffe' => $t,
            'lands' => $l
        ]);
	}

	public function addadminAction()
	{
		
	}

	public function checkadduserdataAction()
	{
		$this->view->disable();
        $error = array();
        $p = $_POST;

		foreach ($p as $k => $v) {
			if(empty($v))
			{
				$error[] = $k;
			}
		}

		if(count($error) < 1)
		{
			echo json_encode(array('res' => 'ok'));
		}
		else {
			echo json_encode($error);
		}
	}

	public function saveuserAction()
	{
		if(isset($_POST['action']) && $_POST['action'] == 'save')
		{
			$user = new User();
			if(!empty($_POST['aprefix']))
			{
				$user->prefix = $_POST['aprefix'];
			}
			else {
				$user->prefix = '---';
			}

			$user->firstname = $_POST['afirstname'];
			$user->lastname = $_POST['alastname'];
			$user->email = $_POST['aemail'];
			$user->password = password_hash($_POST['apassword'], PASSWORD_BCRYPT);
			if(!empty($_POST['aphone']))
			{
				$user->phone = $_POST['aphone'];
			}
			else {
				$user->phone = '---';
			}

			if(!empty($_POST['acompany']))
			{
				$user->company = $_POST['acompany'];
			}
			else {
				$user->company = '---';
			}

			$user->street = $_POST['astreet'];
			$user->zip = $_POST['azip'];
			$user->city = $_POST['acity'];

			if(!empty($_POST['asteuerid']))
			{
				$user->steuerid = $_POST['asteuerid'];
			}
			else {
				$user->steuerid = '---';
			}

			if(!empty($_POST['aland']))
			{
				$user->land = $_POST['aland'];
			}
			else
			{
				$user->land = '---';
			}

			$user->user_group = 1;
			$user->hidden = 0;
			$user->deleted = 0;

			if(isset($_POST['setactive']) && $_POST['setactive'] == 1)
			{
				$active = 1;
			}
			else {
				$active = 0;
			}

			$result = $user->create();

			if(!$result)
			{
				print_r($user->getMessages());
			}
			else {
				$this->dispatcher->forward(array(
					"controller" => "adminaccount",
					"action" => "create",
					"params" => array('tariff' => $_POST['atariff'], 'active' => $active)
				));
			}

		}
	}
}
