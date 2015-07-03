<?php

class User extends BaseModel
{
	var $projects = array();
	
	public function initialize()
	{
		$this->belongsTo('user_group', 'Usergroup', 'id');
		$this->belongsTo('land', 'Land', 'id');
	}

	public static function getUser($uid)
	{
		$user = User::findFirstById($uid);
		return $user;
	}
	
	public static function getUsers($company, $order)
	{
		return User::find($company.' and user_group = 1 order by '.$order.' asc');
	}	
}
