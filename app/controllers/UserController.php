<?php 

class UserController extends ControllerBase
{
	public function indexAction()
	{

	}

	public function newAction()
	{
		$t = Tariff::find();
		$l = Land::find();
        $this->view->setVars([
            'tariffe' => $t,
            'lands' => $l 
        ]);
	}

	public function checkdataAction()
	{
		$this->view->disable();
        $error = array();
        $p = $_POST;

        foreach($p as $k=>$v)
        {
            if(empty($v))
            {
                $error[] = $k;
            }
        }


        if($p['agb'] == 'false')
        {
            $error[] = 'agb';
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

	public function createuserAction()
	{

		$error = array();

        if(isset($_POST['action']))
        {
            foreach($_POST as $k=>$v)
            {
                if($v == 'action') continue;

                if(empty($v))
                {
                    $error[] = $k;
                }
            }

            $user = new User();
            $user->email = $_POST['email'];
            $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user->prefix = $_POST['prefix'];
            $user->firstname = $_POST['firstname'];
            $user->lastname = $_POST['lastname'];;
            
            if(!empty($_POST['company']))
            {
            	$user->company = $_POST['company'];
            }
            else
            {
            	$user->company = '---';
            }
            if(!empty($_POST['steuerid']))
            {
            	$user->steuerid = $_POST['steuerid'];
            }
            else
            {
            	$user->steuerid = '---';
            }
            	
            $user->street = $_POST['street'];
            $user->zip = $_POST['zip'];
            $user->city = $_POST['city'];
            $user->land = $_POST['land'];
            
            if(!empty($_POST['phone']))
            {
            	$user->phone = $_POST['phone'];
            }
            else
            {
            	$user->phone = '---';
            }

            $user->user_group = 1;
            $user->hidden = 0;
            $user->deleted = 0;

            $result = $user->create();

            if(!$result) {
                print_r($user->getMessages());
            }
            else
            {

                $this->dispatcher->forward(array(
                   "controller" => "account",
                   "action"     => "create",
                   "params" => array('tariff' => $_POST['tariff'])
                ));
            }
        }
	}

	public function confirmAction($userid)
	{
		$user = User::findFirstById($userid);
       
        $conditions = "user_id = ".$user->id;
        
        $account = Account::findFirst(array(
            $conditions
        ));
        
        
        $conditionTariff = "id = ".$account->tariff_id;

        $tariff = Tariff::findFirst(array(
           $conditionTariff
        ));

        switch($user->prefix)
        {
            case 'Frau':
                $prefix = 'geehrte Frau';
                break;
            case 'Herr':
                $prefix = 'geehrter Herr';
                break;
            default:
                break;
        }
        
        $this->view->setVars([
            'confirmCreatedCustomer' => $user,
            'akey' => $account->akey,
            'tariff' => $tariff->title,
            'prefix' => $prefix,
        ]);
	}
}