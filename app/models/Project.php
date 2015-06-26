<?php

class Project extends BaseModel
{
	public function initialize()
	{
	    $this->belongsTo('user_id', 'User', 'id');
	    $this->hasMany('id', 'Webbook', 'project_id');
	}

	public static function getTitle($wpid)
	{
		$project = Project::findFirst("id = ".$wpid);
		return $project->title;
	}

	public static function getId($wpid)
	{
		$project = Project::findFirst("id = ".$wpid);
		return $project->id;
	}
}
