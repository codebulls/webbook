<?php

class AdminaccountController extends ControllerBase
{
    public function indexAction()
    {
        $accounts = Account::find();
        $this->view->setVars([
            'accounts' => $accounts
        ]);
    }

    public function activateAction($aid)
    {
        $account = Account::findFirstById($aid);
        $tariff = Tariff::findFirst("id = ".$account->tariff_id);
        $account->active = 1;
        $account->active_from = date('Y-m-d H:i:s');
        $account->active_untill = date('Y-m-d H:i:s', strtotime('+1 year'));
        if(!($account->update()))
        {
            print_r('Error');
        }
        else
        {
            $this->response->redirect("adminaccount");
        }
    }

    public function deactivateAction($aid)
    {
        $account = Account::findFirstById($aid);

        $account->active = 0;
        if(!($account->update()))
        {
            print_r('error');
        }
        else
        {
            $this->response->redirect("adminaccount");
        }
    }

    public function createAction($tariff, $active)
    {
        $users = User::find();
        $id = $users->getLast();
        $user_id = User::findFirstById($id->id);
        $account = new Account();
        $account->tariff_id = $tariff;
        $account->user_id = $user_id->id;
        $account->active = $active;
        $account->akey = sha1(time());
        $account->created_at = date("Y-m-d H:i:s");
        $account->user_deactivate = 0;
        $account->user_deactivate_confirm = 0;
        $account->deleted = 0;
        $account->hidden = 0;

        $result = $account->create();

        if(!$result)
        {
            print_r('Fehler!!!');exit;
        }
        else
        {
            $account = Account::findFirst("user_id = ".$user_id->id);

            $cpath = getcwd()."/customers/";

            if(!file_exists($cpath.$account->akey))
            {
                if(mkdir($cpath.$account->akey, 0755, true))
                {
                    if(mkdir($cpath.$account->akey."/pdfs", 0755, true) && mkdir($cpath.$account->akey."/webbook", 0755, true))
                    {
                        $this->response->redirect("adminuser");
                    }
                }
                else {
                    print_r('Fehler!!! - mkdir');exit;
                }
            }
            else {
                print_r('Fehler!!! - file_exists');exit;
            }
        }
    }
}
