<?php

class AccountController extends ControllerBase
{
	public function indexAction()
	{
        $s = $this->session->get('c_auth');
        $user = User::findFirstById($s['id']);

        $cForAccount = "user_id = ".$s['id'];
        $account = Account::findFirst(array($cForAccount));

        $cForTariff  = "id = ".$account->tariff_id;
        $tariff = Tariff::findFirst(array($cForTariff));

        $this->view->setVars([
            'user' => $user,
            'account' => $account,
            'tariff' => $tariff
        ]);
	}


	public function createAction($tariff)
	{
        $users = User::find();
        $id = $users->getLast();
        $user_id = User::findFirstById($id->id);
        $account = new Account();
        $account->tariff_id = $tariff;
        $account->user_id = $user_id->id;
        $account->active = 0;
        $account->akey = sha1(time());
        $account->created_at = date("Y-m-d H:i:s");
        $account->user_deactivate = 0;
        $account->user_deactivate_confirm = 0;
        $account->deleted = 0;
        $account->hidden = 0;
        $result = $account->create();

        if(!$result) {
            print_r($account->getMessages());
        }
        else
        {
            $conditions = "user_id = ".$user_id->id;

            $account = Account::findFirst(array(
                $conditions
            ));

            $cpath = getcwd()."/customers/";

            if (!file_exists($cpath.$account->akey))
            {
                if(mkdir($cpath.$account->akey, 0755, true))
                {
                    if(mkdir($cpath.$account->akey."/pdfs", 0755, true) && mkdir($cpath.$account->akey."/webbook", 0755, true))
                    {
                        $this->dispatcher->forward(array(
                            "controller" => "user",
                            "action" => "confirm",
                            "params" => array('userid' => $user_id->id)
                        ));
                    }
                }
                else
                {
                    //Weiterleitung an Fehler-Seite
                }
            }
            else
            {
                //Weiterleitung an Fehler-Seite
            }
        }
	}
}