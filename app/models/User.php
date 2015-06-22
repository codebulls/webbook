<?php

class User extends BaseModel
{
	public function initialize()
	{
		$this->hasOne('id', 'Account', 'user_id');
	}
}