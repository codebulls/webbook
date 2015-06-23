<?php

class User extends BaseModel
{
	public function initialize()
	{
		$this->belongsTo('user_group', 'Usergroup', 'id');
	}
}