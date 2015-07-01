<?php

class Webbook extends BaseModel
{
	public $title;

    public function initialize()
    {
        $this->belongsTo('account_id', 'Account', 'id');
        $this->belongsTo('project_id', 'Project', 'id');
    }

    public static function getcount($pid)
    {
    	$webbooks = Webbook::find("project_id=".$pid);
    	return count($webbooks);
    }

    public static function getprojectwebbooks($pid)
    {
		$webbooks = Webbook::query()
		    ->where("project_id = ".$pid)
		    ->limit(4)
		    ->order("created_at desc")
		    ->execute();

        return $webbooks;
    }

	public static function getAccWebbooks($aid)
	{
		$webbooks = Webbook::find("account_id = ".$aid);
		return count($webbooks);
	}

	public static function getAwebbooks($aid)
	{
		$webbooks = Webbook::find("account_id = ".$aid);
		return $webbooks;
	}


	public static function getticketcounternext($uid)
	{
		$ticket = Ticket::find("user_id = ".$uid);
		return count($ticket)+1;
	}

	public static function getticketcounter($wid)
	{
		$ticket = Ticket::find("webbook_id = ".$wid);
		return count($ticket);
	}

	public static function gettickets($wid)
	{
		$tickets = Ticket::find("webbook_id = ".$wid);
		return $tickets;
	}
}
