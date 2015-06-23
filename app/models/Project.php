<?php

class Project extends BaseModel
{
	public function initialize()
	{
	    $this->belongsTo('user_id', 'User', 'id');
	    $this->hasMany('id', 'Webbook', 'project_id');
	}
}