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

	public static function getAccProjects($cid)
	{
		$projects = Project::find("user_id = ".$cid);
		return count($projects);
	}
/*
	public static function getAprojects($uid)
	{
		$projects = Project::find("user_id = ".$uid);
		return $projects;
	}*/
	
	public static function getProjects($uid)
	{
		$projects = Project::query()
			->where("user_id = ".$uid)
			->order("title asc")
			->execute();
		return $projects;
	}
}
