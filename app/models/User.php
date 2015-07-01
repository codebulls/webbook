<?php

class User extends BaseModel
{
	
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
}
