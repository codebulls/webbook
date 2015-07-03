<?php

class Account extends BaseModel
{
	public function initialize()
    {
        $this->belongsTo('user_id', 'User', 'id');
        $this->belongsTo('tariff_id', 'Tariff', 'id');
    }

	public static function getCustomerAccount($cid)
	{
		$account = Account::findFirst("user_id = ".$cid);
		return $account;
	}
}
