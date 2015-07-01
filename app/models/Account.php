<?php

class Account extends BaseModel
{
	public function initialize()
    {
        $this->belongsTo('user_id', 'User', 'id');
        $this->belongsTo('tariff_id', 'Tariff', 'id');
    }

	public static function getCustomerAccounts()
	{
		$accounts = Account::find();
		$u = array();

		foreach ($accounts as $a)
		{
			$u[] = User::find("id = ".$a->user_id);
		}

		return $u;
	}
}
