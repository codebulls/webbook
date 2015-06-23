<?php

class Webbook extends BaseModel
{
	public $title;

    public function initialize()
    {
        $this->belongsTo('account_id', 'Account', 'id');
        $this->belongsTo('project_id', 'Project', 'id');
    }

    public function getcount($pid)
    {
    	$webbooks = Webbook::find("project_id=".$pid);
    	return count($webbooks);
    }
}