<?php

class AdmincenterController extends ControllerBase
{
	public function indexAction()
	{
		$this->view->setVars([
			'user' => $this->getAdmin()
		]);
	}
}
