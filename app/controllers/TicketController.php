<?php

class TicketController extends ControllerBase
{
  public function indexAction()
  {

  }

  public function createAction($wid)
  {
    if(isset($_POST['action']) && $_POST['action'] == 'tcreate' && !empty($wid) && is_numeric($wid))
    {
      if(!empty($_POST['ttitle']) && !empty($_POST['tmsg']))
      {
        $ticket = new Ticket();

        $ticket->user_id = $this->gUserId();
        $ticket->webbook_id = $wid;
        $ticket->title = $_POST['ttitle'];
        $ticket->content = $_POST['tmsg'];

        $result = $ticket->create();

        if(!$result)
        {
          print_r('Fehler!!');
        }
        else
        {
          $this->response->redirect("webbook");
        }
      }
    }
  }
}
