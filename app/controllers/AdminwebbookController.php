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
}