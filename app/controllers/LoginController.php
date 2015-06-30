<?php

class LoginController extends ControllerBase
{
	public function indexAction()
	{

	}

	public function _registerAdminSession(User $user)
	{
		$this->session->set('a_auth', array(
			'id' => $user->id,
			'name' => $user->firstname.' '.$user->lastname
		));
	}

	public function _registerCustomerSession(User $user)
	{
		$this->session->set('c_auth', array(
			'id' => $user->id,
			'name' => $user->firstname.' '.$user->lastname
		));
	}

	public function startAction()
	{
		if($this->request->isPost())
		{
			if(!empty($this->request->getPost('email')) && !empty($this->request->getPost('password')))
			{
				$email = $this->request->getPost('email');
				$password = $this->request->getPost('password');

				$user = User::findFirst(array(
					"email = :email:",
					'bind' => array('email' => $email)
				));

				$ca = "user_id = ".$user->id;
				$account = Account::findFirst(array($ca));

				if(password_verify($password, $user->password) != false)
				{
					if($user->user_group == 2)
					{
						$this->_registerAdminSession($user);
						return $this->response->redirect("admincenter");
					}
					elseif($user->user_group == 1 && $account->active == 1)
					{
						$this->_registerCustomerSession($user);
						return $this->response->redirect("center");
					}
					else
					{
						return $this->dispatcher->forward(array(
							"controller" => "login",
							"action" => "index"
						));
					}

				}
				else
				{
					return $this->dispatcher->forward(array(
						"controller" => "login",
						"action" => "index"
					));
				}
			}
			else
			{
				$this->dispatcher->forward(array(
					"controller" => "login",
					"action" => "index"
				));
			}
		}
		else
		{
			return $this->dispatcher->forward(array(
				"controller" => "login",
				"action" => "index"
			));
		}
	}

	public function endAction()
    {
    	if ($this->session->has("a_auth"))
    	{
    		$this->session->remove('a_auth');
    		return $this->dispatcher->forward(array("controller" => "index", "action" => "index"));
    	}
    	else
    	{
    		$this->session->remove('c_auth');
    		return $this->dispatcher->forward(array("controller" => "index", "action" => "index"));
    	}
    }
}
